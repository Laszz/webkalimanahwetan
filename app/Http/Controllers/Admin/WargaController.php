<?php

// Controller data warga sisi ADMIN - pantau dan hapus biodata yang bermasalah

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Warga;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class WargaController extends Controller
{
    // Semua biodata + akun pemilik, terbaru dulu 15 per halaman
    public function index(): View
    {
        $wargas = Warga::with('user:id,name,email')->latest()->paginate(15);

        return view('admin.warga.index', compact('wargas'));
    }

    // Detail biodata + akun pemilik
    public function show(Warga $warga): View
    {
        $warga->load('user:id,name,email');

        return view('admin.warga.show', compact('warga'));
    }

    // Hapus biodata bermasalah (akun user tetap ada untuk verifikasi ulang)
    public function destroy(Warga $warga): RedirectResponse
    {
        $warga->delete();

        return redirect()
            ->route('admin.warga.index')
            ->with('success', 'Biodata warga dihapus.');
    }

    // Unduh seluruh biodata warga sebagai Excel
    public function export(): BinaryFileResponse
    {
        $wargas = Warga::with('user:id,name,email')->latest()->get();

        // Judul laporan + kepala kolom
        $lembar = (new Spreadsheet())->getActiveSheet();
        $lembar->setCellValue('A1', 'DATA WARGA DESA KALIMANAH WETAN TAHUN ' . now()->format('Y'));
        $lembar->mergeCells('A1:N1');
        $lembar->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $lembar->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $kepala = ['Nama', 'Email', 'NIK', 'No. KK', 'Tempat Lahir', 'Tanggal Lahir', 'Jenis Kelamin', 'Alamat', 'RT', 'RW', 'Agama', 'Status Kawin', 'Pekerjaan', 'Telepon'];
        foreach ($kepala as $kolom => $judul) {
            $lembar->setCellValue([$kolom + 1, 2], $judul);
        }
        $lembar->getStyle('A2:N2')->getFont()->setBold(true);

        // Satu baris per warga; NIK/KK/RT/RW/telepon ditulis sebagai teks agar 16 digit utuh
        $baris = 3;
        foreach ($wargas as $warga) {
            $lembar->setCellValue([1, $baris], $warga->nama);
            $lembar->setCellValue([2, $baris], $warga->user->email ?? '-');
            $lembar->setCellValueExplicit([3, $baris], $warga->nik, DataType::TYPE_STRING);
            $lembar->setCellValueExplicit([4, $baris], $warga->no_kk, DataType::TYPE_STRING);
            $lembar->setCellValue([5, $baris], $warga->tempat_lahir);
            $lembar->setCellValue([6, $baris], $warga->tanggal_lahir?->format('d-m-Y'));
            $lembar->setCellValue([7, $baris], $warga->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan');
            $lembar->setCellValue([8, $baris], $warga->alamat);
            $lembar->setCellValueExplicit([9, $baris], $warga->rt, DataType::TYPE_STRING);
            $lembar->setCellValueExplicit([10, $baris], $warga->rw, DataType::TYPE_STRING);
            $lembar->setCellValue([11, $baris], $warga->agama);
            $lembar->setCellValue([12, $baris], $warga->status_kawin);
            $lembar->setCellValue([13, $baris], $warga->pekerjaan);
            $lembar->setCellValueExplicit([14, $baris], $warga->telepon, DataType::TYPE_STRING);
            $baris++;
        }

        // Lebar kolom menyesuaikan isi
        foreach (range('A', 'N') as $huruf) {
            $lembar->getColumnDimension($huruf)->setAutoSize(true);
        }

        // Simpan sementara lalu unduh
        $jalur = storage_path('app/data-warga-' . now()->format('Ymd-His') . '.xlsx');
        (new Xlsx($lembar->getParent()))->save($jalur);

        return response()->download($jalur, 'data-warga-' . now()->format('Ymd-His') . '.xlsx')->deleteFileAfterSend();
    }
}
