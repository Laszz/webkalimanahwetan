<?php

// Controller pengajuan surat sisi WARGA - ajukan layanan dan pantau status milik sendiri

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Http\Requests\Warga\StorePengajuanRequest;
use App\Models\Layanan;
use App\Models\PengajuanLayanan;
use App\Models\User;
use App\Notifications\PengajuanMasuk;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PengajuanController extends Controller
{
    // Riwayat pengajuan milik sendiri + nama layanan, terbaru dulu 10 per halaman
    public function index(): View
    {
        $pengajuans = auth()->user()->pengajuanLayanan()->with('layanan:id,nama')->latest()->paginate(10);

        return view('warga.pengajuan.index', compact('pengajuans'));
    }

    // Form ajukan: wajib datang dari tombol Ajukan satu layanan (?layanan=id)
    public function create(Request $request): View|RedirectResponse
    {
        // Biodata wajib lengkap dulu
        if (! auth()->user()->warga) {
            return redirect()
                ->route('warga.dashboard')
                ->with('lengkapi', 'Silahkan lengkapi data diri untuk memakai fitur website.');
        }

        $layanan = $request->query('layanan')
            ? Layanan::aktif()->with('syaratLayanan')->findOrFail($request->query('layanan'))
            : null;

        // Belum pilih layanan = kembali ke daftar
        if (! $layanan) {
            return redirect()->route('warga.layanan.index');
        }

        return view('warga.pengajuan.create', compact('layanan'));
    }

    // Simpan pengajuan + semua syarat dalam satu transaksi database
    public function store(StorePengajuanRequest $request): RedirectResponse
    {
        // Biodata wajib lengkap dulu
        if (! auth()->user()->warga) {
            return redirect()
                ->route('warga.dashboard')
                ->with('lengkapi', 'Silahkan lengkapi data diri untuk memakai fitur website.');
        }

        $data = $request->validated();
        $layanan = Layanan::aktif()->findOrFail($data['layanan_id']);

        $pengajuan = null;
        DB::transaction(function () use ($request, $data, $layanan, &$pengajuan) {
            // Pengajuan induk milik user login
            $pengajuan = $request->user()->pengajuanLayanan()->create([
                'layanan_id' => $layanan->id,
                'keperluan' => $data['keperluan'] ?? null,
            ]);

            // Simpan tiap syarat: file ke storage atau teks ke kolom isi
            foreach ($layanan->syaratLayanan as $syarat) {
                $file = $request->file("syarat.{$syarat->id}");
                $teks = $request->input("syarat.{$syarat->id}");

                if ($file) {
                    $pengajuan->uploadSyaratLayanan()->create([
                        'syarat_layanan_id' => $syarat->id,
                        'file_path' => $file->store('syarat', 'public'),
                    ]);
                } elseif ($teks) {
                    $pengajuan->uploadSyaratLayanan()->create([
                        'syarat_layanan_id' => $syarat->id,
                        'isi' => $teks,
                    ]);
                }
            }
        });

        // Beri tahu semua admin agar segera diverifikasi
        $admins = User::where('role', 'admin')->get();
        Notification::send($admins, new PengajuanMasuk($pengajuan->loadMissing(['user:id,name', 'layanan:id,nama'])));

        return redirect()
            ->route('warga.pengajuan.index')
            ->with('success', 'Pengajuan terkirim dan menunggu diproses.');
    }

    // Unduh dokumen hasil pengajuan yang sudah selesai (milik sendiri saja)
    public function unduh(PengajuanLayanan $pengajuan): BinaryFileResponse|RedirectResponse
    {
        // Bukan milik sendiri, belum selesai, atau belum ada file = kembali
        if ($pengajuan->user_id !== auth()->id() || $pengajuan->status !== 'selesai' || ! $pengajuan->file_hasil) {
            return redirect()->route('warga.pengajuan.index');
        }

        $jalur = Storage::disk('local')->path($pengajuan->file_hasil);

        // File hilang di storage = kembali tanpa error
        if (! is_file($jalur)) {
            return redirect()->route('warga.pengajuan.index');
        }

        // Nama file = nama layanan, mis. surat-pembuatan-skck.pdf
        $namaFile = Str::slug($pengajuan->loadMissing('layanan:id,nama')->layanan->nama ?? 'hasil-layanan') . '.pdf';

        return response()->download($jalur, $namaFile);
    }
}
