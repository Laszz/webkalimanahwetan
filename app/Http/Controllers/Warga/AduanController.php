<?php

// Controller aduan sisi WARGA - lapor baru dan riwayat milik sendiri

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Http\Requests\Warga\StoreAduanRequest;
use App\Models\Aduan;
use App\Models\User;
use App\Notifications\AduanMasuk;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\View\View;

class AduanController extends Controller
{
    // Daftar semua aduan warga (transparansi) + cari judul/isi; hero = terbaru, sisanya 8 per halaman
    public function index(Request $request): View
    {
        // Kata kunci pencarian dari query ?q=
        $cari = trim((string) $request->query('q', ''));

        $query = Aduan::query()
            ->latest()
            ->when($cari !== '', fn ($q) => $q->where(function ($w) use ($cari) {
                $w->where('judul', 'like', "%{$cari}%")
                    ->orWhere('isi', 'like', "%{$cari}%");
            }));

        // Tanpa pencarian di halaman 1: aduan paling baru tampil besar di atas
        $aduanTerbaru = null;
        if ($cari === '' && (int) $request->query('page', 1) === 1) {
            $aduanTerbaru = (clone $query)->first();
            if ($aduanTerbaru) {
                $query->whereKeyNot($aduanTerbaru->getKey());
            }
        }

        $aduans = $query->paginate(8)->withQueryString();

        // Judul + sub transparansi untuk semua pengunjung
        $judul = 'Aduan Warga';
        $sub = 'Laporan warga yang masuk dan ditindaklanjuti perangkat desa.';

        return view('warga.aduan.index', compact('aduans', 'aduanTerbaru', 'cari', 'judul', 'sub'));
    }

    // Form lapor aduan baru; biodata wajib lengkap dulu
    public function create(): View|RedirectResponse
    {
        if (! auth()->user()->warga) {
            return redirect()
                ->route('warga.dashboard')
                ->with('lengkapi', 'Silahkan lengkapi data diri untuk memakai fitur website.');
        }

        return view('warga.aduan.create');
    }

    // Detail aduan + tanggapan admin (publik untuk transparansi)
    public function show(Aduan $aduan): View
    {
        $aduan->load('tanggapanAduan.user:id,name');

        return view('warga.aduan.show', compact('aduan'));
    }

    // Simpan aduan; pelapor otomatis user login, foto disimpan ke storage publik
    public function store(StoreAduanRequest $request): RedirectResponse
    {
        // Biodata wajib lengkap dulu
        if (! auth()->user()->warga) {
            return redirect()
                ->route('warga.dashboard')
                ->with('lengkapi', 'Silahkan lengkapi data diri untuk memakai fitur website.');
        }

        $data = $request->validated();

        // Pindahkan foto bukti ke storage jika ada
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('aduan', 'public');
        }

        $aduan = auth()->user()->aduans()->create($data);

        // Beri tahu semua admin agar segera ditindaklanjuti
        $admins = User::where('role', 'admin')->get();
        Notification::send($admins, new AduanMasuk($aduan->loadMissing('user:id,name')));

        return redirect()
            ->route('warga.aduan.index')
            ->with('success', 'Aduan terkirim dan menunggu tindak lanjut.');
    }
}
