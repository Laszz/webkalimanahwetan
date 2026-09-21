{{-- Halaman notifikasi - daftar pemberitahuan untuk warga (pakai layout warga) --}}
@extends('layouts.warga')

{{-- Judul tab browser --}}
@section('title', 'Notifikasi - Desa Kalimanah')

{{-- CSS + JS khusus halaman ini dimuat via stack layout --}}
@push('styles')
    @vite(['resources/css/warga/notifikasi/index.css'])
@endpush

@section('content')
    {{-- Daftar notifikasi milik sendiri --}}
    <section class="page-container notif" aria-labelledby="notif-judul">
        <div class="notif-head">
            <div>
                <h1 id="notif-judul">Notifikasi</h1>
                <p class="notif-sub">Kabar terbaru untuk akunmu.</p>
            </div>
            @if ($notifikasis->isNotEmpty())
                {{-- Hapus semua sekaligus (minta konfirmasi via JS) --}}
                <form method="POST" action="{{ route('warga.notifikasi.destroyAll') }}" data-konfirmasi="Hapus semua notifikasi?">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-kecil btn-hapus-semua">Hapus Semua</button>
                </form>
            @endif
        </div>

        <ul class="notif-list">
            @forelse ($notifikasis as $notifikasi)
                {{-- Baris belum dibaca ditandai --}}
                <li class="{{ $notifikasi->read_at ? '' : 'baru' }}">
                    <div>
                        {{-- Judul + waktu masuk --}}
                        <strong>{{ $notifikasi->data['judul'] ?? 'Pemberitahuan' }}</strong>
                        <span>{{ $notifikasi->created_at->format('d M Y H.i') }}</span>
                    </div>
                    <div class="notif-aksi">
                        {{-- Buka lewat show agar sekalian ditandai dibaca --}}
                        <a class="btn-kecil btn-lihat" href="{{ route('warga.notifikasi.show', $notifikasi->id) }}">Buka</a>
                        @unless ($notifikasi->read_at)
                            {{-- Tandai satu ini sudah dibaca --}}
                            <form method="POST" action="{{ route('warga.notifikasi.update', $notifikasi->id) }}">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn-kecil btn-baca">Tandai dibaca</button>
                            </form>
                        @endunless
                        {{-- Hapus satu ini --}}
                        <form method="POST" action="{{ route('warga.notifikasi.destroy', $notifikasi->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-kecil btn-hapus" aria-label="Hapus notifikasi"><i class="ph ph-trash" aria-hidden="true"></i></button>
                        </form>
                    </div>
                </li>
            @empty
                {{-- Belum ada notifikasi --}}
                <li><p><strong>Belum ada notifikasi.</strong></p></li>
            @endforelse
        </ul>

        {{-- Navigasi halaman --}}
        {{ $notifikasis->links() }}
    </section>
@endsection

{{-- JS khusus halaman ini dimuat via stack layout --}}
@push('scripts')
    @vite(['resources/js/warga/notifikasi/index.js'])
@endpush
