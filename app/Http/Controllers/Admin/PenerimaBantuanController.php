<?php

// Controller penerima bantuan sisi ADMIN - catat warga penerima per periode

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePenerimaBantuanRequest;
use App\Models\JenisBantuan;
use App\Models\PenerimaBantuan;
use App\Models\Warga;
use App\Notifications\BantuanDiterima;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PenerimaBantuanController extends Controller
{
    // Semua penerima + jenis dan warga, bisa saring per tahun, terbaru dulu 15 per halaman
    public function index(Request $request): View
    {
        $penerimas = PenerimaBantuan::with(['jenisBantuan:id,nama', 'warga:id,nama'])
            ->when($request->query('tahun'), fn ($query, $tahun) => $query->where('tahun', $tahun))
            ->latest()
            ->paginate(15);

        return view('admin.penerima-bantuan.index', compact('penerimas'));
    }

    // Form tambah penerima (pilih jenis + warga terdaftar)
    public function create(): View
    {
        $jenis = JenisBantuan::orderBy('nama')->get(['id', 'nama']);
        $wargas = Warga::orderBy('nama')->get(['id', 'nama']);

        return view('admin.penerima-bantuan.create', compact('jenis', 'wargas'));
    }

    // Simpan penerima baru
    public function store(StorePenerimaBantuanRequest $request): RedirectResponse
    {
        $penerima = PenerimaBantuan::create($request->validated());

        // Beri tahu warga penerima jika akunnya ada
        $penerima->loadMissing(['warga.user:id,name', 'jenisBantuan:id,nama']);
        if ($penerima->warga?->user) {
            $penerima->warga->user->notify(new BantuanDiterima($penerima));
        }

        return redirect()
            ->route('admin.penerima-bantuan.index')
            ->with('success', 'Penerima tersimpan.');
    }

    // Hapus data penerima (riwayat periode berjalan ikut terhapus)
    public function destroy(PenerimaBantuan $penerimaBantuan): RedirectResponse
    {
        $penerimaBantuan->delete();

        return redirect()
            ->route('admin.penerima-bantuan.index')
            ->with('success', 'Penerima dihapus.');
    }

    // Unduh seluruh penerima bantuan sebagai Excel
    public function export(): BinaryFileResponse
    {
        $penerimas = PenerimaBantuan::with(['jenisBantuan:id,nama', 'warga:id,nama,nik'])->latest()->get();

        // Judul laporan + kepala kolom
        $lembar = (new Spreadsheet())->getActiveSheet();
        $lembar->setCellValue('A1', 'DATA PENERIMA BANTUAN DESA KALIMANAH WETAN TAHUN ' . now()->format('Y'));
        $lembar->mergeCells('A1:G1');
        $lembar->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $lembar->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $kepala = ['Program', 'Nama', 'NIK', 'Nominal', 'Periode', 'Keterangan', 'Tahun'];
        foreach ($kepala as $kolom => $judul) {
            $lembar->setCellValue([$kolom + 1, 2], $judul);
        }
        $lembar->getStyle('A2:G2')->getFont()->setBold(true);

        // Satu baris per penerima; NIK ditulis sebagai teks agar 16 digit utuh
        $baris = 3;
        foreach ($penerimas as $penerima) {
            $lembar->setCellValue([1, $baris], $penerima->jenisBantuan->nama ?? '-');
            $lembar->setCellValue([2, $baris], $penerima->warga->nama ?? '-');
            $lembar->setCellValueExplicit([3, $baris], $penerima->warga->nik ?? '-', DataType::TYPE_STRING);
            $lembar->setCellValue([4, $baris], $penerima->nominal);
            $lembar->setCellValue([5, $baris], $penerima->bulan ? 'Bulan ' . $penerima->bulan . ' ' . $penerima->tahun : 'Tahun ' . $penerima->tahun);
            $lembar->setCellValue([6, $baris], $penerima->keterangan ?? '-');
            $lembar->setCellValue([7, $baris], $penerima->tahun);
            $baris++;
        }

        // Lebar kolom menyesuaikan isi
        foreach (range('A', 'G') as $huruf) {
            $lembar->getColumnDimension($huruf)->setAutoSize(true);
        }

        // Simpan sementara lalu unduh
        $jalur = storage_path('app/penerima-bantuan-' . now()->format('Ymd-His') . '.xlsx');
        (new Xlsx($lembar->getParent()))->save($jalur);

        return response()->download($jalur, 'penerima-bantuan-' . now()->format('Ymd-His') . '.xlsx')->deleteFileAfterSend();
    }
}
