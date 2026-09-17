<?php

// Controller pengajuan surat sisi WARGA - ajukan layanan dan pantau status milik sendiri

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Http\Requests\Warga\StorePengajuanRequest;
use App\Models\Layanan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PengajuanController extends Controller
{
    // Riwayat pengajuan milik sendiri + nama layanan, terbaru dulu 10 per halaman
    public function index(): View
    {
        $pengajuans = auth()->user()->pengajuanLayanan()->with('layanan:id,nama')->latest()->paginate(10);

        return view('warga.pengajuan.index', compact('pengajuans'));
    }

    // Form ajukan: pilih layanan (?layanan=id) lalu isi tiap syaratnya
    public function create(Request $request): View
    {
        $layanans = Layanan::aktif()->orderBy('nama')->get(['id', 'nama']);
        $layanan = null;

        // Muat syarat layanan yang dipilih agar form bisa dirender
        if ($request->query('layanan')) {
            $layanan = Layanan::aktif()->with('syaratLayanan')->findOrFail($request->query('layanan'));
        }

        return view('warga.pengajuan.create', compact('layanans', 'layanan'));
    }

    // Simpan pengajuan + semua syarat dalam satu transaksi database
    public function store(StorePengajuanRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $layanan = Layanan::aktif()->findOrFail($data['layanan_id']);

        DB::transaction(function () use ($request, $data, $layanan) {
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

        return redirect()
            ->route('warga.pengajuan.index')
            ->with('success', 'Pengajuan terkirim dan menunggu diproses.');
    }
}
