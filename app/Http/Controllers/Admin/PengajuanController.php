<?php

// Controller verifikasi pengajuan sisi ADMIN - periksa berkas dan tentukan status

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengajuanLayanan;
use App\Models\PerangkatDesa;
use App\Models\ProfilDesa;
use App\Notifications\PengajuanStatus;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\TemplateProcessor;

class PengajuanController extends Controller
{
    // Semua pengajuan + pemohon dan layanan, bisa saring per status, terbaru dulu 15 per halaman
    public function index(Request $request): View
    {
        $pengajuans = PengajuanLayanan::with(['user:id,name', 'layanan:id,nama'])
            ->when($request->query('status'), fn ($query, $status) => $query->byStatus($status))
            ->latest()
            ->paginate(15);

        return view('admin.pengajuan.index', compact('pengajuans'));
    }

    // Detail pengajuan + berkas syarat terunggah untuk diverifikasi
    public function show(PengajuanLayanan $pengajuan): View
    {
        $pengajuan->load(['user:id,name', 'layanan:id,nama', 'uploadSyaratLayanan.syaratLayanan:id,nama,tipe']);

        return view('admin.pengajuan.show', compact('pengajuan'));
    }

    // Ubah status + catatan + nomor surat (mis. alasan penolakan)
    public function update(Request $request, PengajuanLayanan $pengajuan): RedirectResponse
    {
        // Input: status baru, catatan admin, dan nomor surat resmi
        $data = $request->validate([
            'status' => ['required', 'in:menunggu,diproses,selesai,ditolak'],
            'catatan' => ['nullable', 'string'],
            'nomor_surat' => ['nullable', 'string', 'max:255'],
        ]);

        // Status selesai tanpa nomor = buatkan otomatis (admin tetap bisa timpa manual)
        if (($data['status'] ?? null) === 'selesai' && empty($data['nomor_surat']) && empty($pengajuan->nomor_surat)) {
            $data['nomor_surat'] = $this->nomorOtomatis($pengajuan);
        }

        $pengajuan->update($data);

        // Status selesai = pastikan dokumen hasil ada agar bisa diunduh warga
        // (berlaku untuk selesai baru maupun simpan ulang selesai lama yang belum punya file)
        if ($pengajuan->status === 'selesai') {
            $this->generateHasil($pengajuan->loadMissing(['user.warga', 'layanan.templateHasilLayanan']));
        }

        // Beri tahu pemohon jika status benar berubah
        if ($pengajuan->wasChanged('status') && $pengajuan->user) {
            $pengajuan->user->notify(new PengajuanStatus($pengajuan->loadMissing('layanan:id,nama')));
        }

        return redirect()
            ->route('admin.pengajuan.show', $pengajuan)
            ->with('success', 'Status pengajuan diperbarui.');
    }

    // Nomor surat otomatis: 470/{id 3 digit}/{bulan romawi}/{tahun}, mis. 470/004/IX/2026
    private function nomorOtomatis(PengajuanLayanan $pengajuan): string
    {
        $romawi = [1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'][(int) now()->format('n')];

        return '470/' . str_pad((string) $pengajuan->id, 3, '0', STR_PAD_LEFT) . '/' . $romawi . '/' . now()->format('Y');
    }

    // Isi template Word layanan dengan biodata pemohon lalu simpan sebagai PDF hasil
    private function generateHasil(PengajuanLayanan $pengajuan): void
    {
        // PDF sudah ada = pakai yang lama, jangan tindih; sisa docx lama dihapus lalu generate ulang
        if ($pengajuan->file_hasil && Storage::disk('local')->exists($pengajuan->file_hasil)) {
            if (str_ends_with($pengajuan->file_hasil, '.pdf')) {
                return;
            }
            Storage::disk('local')->delete($pengajuan->file_hasil);
        }

        // Tanpa template aktif = tidak ada yang digenerate
        $template = $pengajuan->layanan->templateHasilLayanan ?? null;
        if (! $template || ! $template->aktif) {
            return;
        }

        $biodata = $pengajuan->user->warga;
        $waktu = now();

        // Nama kepala desa aktif untuk tanda tangan (urutan terkecil)
        $kepalaDesa = PerangkatDesa::where('aktif', true)
            ->where('jabatan', 'like', '%kepala desa%')
            ->orderBy('urutan')
            ->first();

        // Profil desa untuk kop surat
        $profilDesa = ProfilDesa::first();

        // Nilai tiap variabel {{ ... }} di template; kosong = strip
        $nilai = [
            'nama' => $biodata->nama ?? '',
            'nik' => $biodata->nik ?? '',
            'no_kk' => $biodata->no_kk ?? '',
            'tempat_lahir' => $biodata->tempat_lahir ?? '',
            'tanggal_lahir' => $biodata->tanggal_lahir?->format('d M Y') ?? '',
            'jenis_kelamin' => ($biodata->jenis_kelamin ?? '') === 'L' ? 'Laki-laki' : 'Perempuan',
            'alamat' => $biodata->alamat ?? '',
            'rt' => $biodata->rt ?? '',
            'rw' => $biodata->rw ?? '',
            'agama' => $biodata->agama ?? '',
            'status_kawin' => $biodata->status_kawin ?? '',
            'pekerjaan' => $biodata->pekerjaan ?? '',
            'telepon' => $biodata->telepon ?? '',
            'keperluan' => $pengajuan->keperluan ?? '',
            'nama_layanan' => $pengajuan->layanan->nama ?? '',
            'nomor_surat' => $pengajuan->nomor_surat ?? '',
            'tanggal_surat' => $waktu->format('d M Y'),
            'nama_kepala_desa' => $kepalaDesa->nama ?? '',
            'alamat_desa' => $profilDesa->alamat ?? '',
            'kode_pos_desa' => $profilDesa->kode_pos ?? '',
            'telepon_desa' => $profilDesa->telepon ?? '',
            'email_desa' => $profilDesa->email ?? '',
        ];

        // Template gaya Blade {{ nama }} (spasi bebas); cocokkan per variabel yang benar ditemukan
        $prosesor = new TemplateProcessor(Storage::disk('local')->path($template->file_path));
        $prosesor->setMacroChars('{{', '}}');
        foreach ($prosesor->getVariables() as $variabel) {
            $kunci = strtolower(trim($variabel));
            if (array_key_exists($kunci, $nilai)) {
                $prosesor->setValue($variabel, $nilai[$kunci]);
            }
        }

        // Isi docx sementara lalu konversi ke PDF (PhpWord tidak membuat folder otomatis)
        Storage::disk('local')->makeDirectory('hasil-layanan');
        $jalurDocx = 'hasil-layanan/pengajuan-' . $pengajuan->id . '.docx';
        $jalurPdf = 'hasil-layanan/pengajuan-' . $pengajuan->id . '.pdf';
        $prosesor->saveAs(Storage::disk('local')->path($jalurDocx));

        // Render via Dompdf langsung: writer bawaan PhpWord memaksa border hitam
        // ke semua tabel, jadi border paksa itu dibuang agar tabel Word yang
        // borderless tetap borderless di PDF
        $dokumen = IOFactory::load(Storage::disk('local')->path($jalurDocx));
        $html = str_replace(
            '1px solid black',
            '0',
            IOFactory::createWriter($dokumen, 'HTML')->getContent()
        );

        $opsi = new Options();
        $dompdf = new Dompdf($opsi);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->loadHtml($html);
        $dompdf->render();
        Storage::disk('local')->put($jalurPdf, $dompdf->output());
        Storage::disk('local')->delete($jalurDocx);

        $pengajuan->update(['file_hasil' => $jalurPdf]);
    }
}
