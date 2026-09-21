{{-- Halaman periksa pengajuan + ubah status + catatan (pakai layout admin) --}}
@extends('layouts.admin')

{{-- Judul tab + judul bar atas --}}
@section('title', 'Periksa Pengajuan - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/admin/pengajuan/show.css'])
@endpush

@section('content')
    {{-- Info pengajuan --}}
    <section class="detail" aria-labelledby="pengajuan-judul">
        <h1 id="pengajuan-judul">Pengajuan: {{ $pengajuan->layanan->nama ?? '-' }}</h1>
        {{-- Baris pemohon + tanggal + status --}}
        <p class="detail-meta">
            <span class="status status-{{ $pengajuan->status }}">{{ ucfirst($pengajuan->status) }}</span>
            <span>{{ $pengajuan->user->name ?? '-' }} · {{ $pengajuan->created_at->format('d M Y H.i') }}</span>
        </p>

        @if ($pengajuan->keperluan)
            <p class="detail-sub">Keperluan: {{ $pengajuan->keperluan }}</p>
        @endif

        {{-- Berkas syarat terunggah --}}
        <h2 class="kartu-judul">Berkas Syarat</h2>
        <ul class="berkas-list">
            @forelse ($pengajuan->uploadSyaratLayanan as $upload)
                <li>
                    {{-- Nama syarat + isi/file --}}
                    <strong>{{ $upload->syaratLayanan->nama ?? '-' }}</strong>
                    @if ($upload->file_path)
                        <a href="{{ asset('storage/' . $upload->file_path) }}" target="_blank" rel="noopener">Lihat file</a>
                    @else
                        <span>{{ $upload->isi }}</span>
                    @endif
                </li>
            @empty
                {{-- Tanpa berkas --}}
                <li class="kosong">Tanpa berkas syarat.</li>
            @endforelse
        </ul>

        {{-- Form ubah status + catatan --}}
        <h2 class="kartu-judul">Keputusan</h2>
        <form class="form-card" method="POST" action="{{ route('admin.pengajuan.update', $pengajuan) }}">
            @csrf
            @method('PUT')
            <div class="field">
                <label for="status">Status</label>
                <select id="status" name="status" required>
                    <option value="menunggu" @selected($pengajuan->status === 'menunggu')>Menunggu</option>
                    <option value="diproses" @selected($pengajuan->status === 'diproses')>Diproses</option>
                    <option value="selesai" @selected($pengajuan->status === 'selesai')>Selesai</option>
                    <option value="ditolak" @selected($pengajuan->status === 'ditolak')>Ditolak</option>
                </select>
            </div>
            <div class="field">
                <label for="catatan">Catatan (mis. alasan penolakan)</label>
                <textarea id="catatan" name="catatan" rows="3">{{ old('catatan', $pengajuan->catatan) }}</textarea>
            </div>
            {{-- Nomor resmi untuk dokumen hasil; kosong = otomatis --}}
            <div class="field">
                <label for="nomor_surat">Nomor Surat (kosongkan untuk otomatis)</label>
                <input id="nomor_surat" type="text" name="nomor_surat" value="{{ old('nomor_surat', $pengajuan->nomor_surat) }}" autocomplete="off" placeholder="cth. 470/001/IX/2026">
            </div>
            @if (!($pengajuan->layanan->templateHasilLayanan->aktif ?? false))
                <p class="field-info">Layanan ini belum punya template aktif — dokumen hasil tidak akan tergenerate.</p>
            @endif
            <button type="submit" class="btn-simpan">Simpan Keputusan</button>
        </form>

        {{-- Tombol kembali ke daftar --}}
        <div class="aksi-bawah">
            <a class="btn-sekunder" href="{{ route('admin.pengajuan.index') }}">Kembali</a>
        </div>
    </section>

    {{-- Popup hasil aksi (tampil jika ada pesan sesi) --}}
    @if (session('success'))
        <div class="popup" id="popup" role="alertdialog" aria-modal="true" aria-label="Hasil aksi">
            <div class="popup-kartu">
                <i class="ph ph-check-circle popup-ok" aria-hidden="true"></i>
                <p>{{ session('success') }}</p>
                <button type="button" class="btn-kecil btn-setuju" data-tutup>Tutup</button>
            </div>
        </div>
    @endif
@endsection

{{-- JS khusus halaman ini dimuat via stack layout --}}
@push('scripts')
    @vite(['resources/js/admin/pengajuan/show.js'])
@endpush
