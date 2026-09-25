{{-- Halaman tindak lanjut aduan - ubah status + tulis/hapus tanggapan (pakai layout admin) --}}
@extends('layouts.admin')

{{-- Judul tab + judul bar atas --}}
@section('title', 'Tindak Lanjut Aduan - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/admin/aduan/edit.css'])
@endpush

@section('content')
    {{-- Tindak lanjut aduan terpilih --}}
    <section class="detail" aria-labelledby="aduan-judul">
        <h1 id="aduan-judul">{{ $aduan->judul }}</h1>
        {{-- Baris status + pelapor + tanggal --}}
        <p class="detail-meta">
            <span class="status status-{{ $aduan->status }}">{{ ucfirst($aduan->status) }}</span>
            <span>{{ $aduan->user->name ?? '-' }} · {{ $aduan->created_at->format('d M Y H.i') }}</span>
        </p>

        {{-- Satu kartu tindak lanjut: ubah status + tulis tanggapan --}}
        <h2 class="kartu-judul">Tindak Lanjut</h2>
        <form class="form-baru" method="POST" action="{{ route('admin.aduan.update', $aduan) }}">
            @csrf
            @method('PUT')
            <div class="field">
                <label for="status">Status</label>
                <select id="status" name="status" required>
                    <option value="menunggu" @selected($aduan->status === 'menunggu')>Menunggu</option>
                    <option value="diproses" @selected($aduan->status === 'diproses')>Diproses</option>
                    <option value="selesai" @selected($aduan->status === 'selesai')>Selesai</option>
                </select>
            </div>
            <div class="field">
                <label for="isi">Tanggapan (kosongkan jika tidak membalas)</label>
                <textarea id="isi" name="isi" rows="3">{{ old('isi') }}</textarea>
                @foreach ((array) $errors->get('isi') as $msg)
                    <p class="field-error" role="alert">{{ $msg }}</p>
                @endforeach
            </div>
            {{-- Baris tombol simpan + kembali sejajar dalam kartu --}}
            <div class="aksi-baris">
                <button type="submit" class="btn-simpan">Simpan</button>
                <a class="btn-sekunder" href="{{ route('admin.aduan.index') }}">Kembali</a>
            </div>
        </form>
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
    @vite(['resources/js/admin/aduan/edit.js'])
@endpush
