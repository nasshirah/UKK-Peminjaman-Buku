@extends('layouts.user')

@section('title', 'Peminjaman Buku')

@section('content')

{{-- Alert success --}}
@if(session('success'))
<div class="alert alert-dismissible fade show border-0 shadow-sm mb-4" role="alert"
    style="border-radius: 12px; background: #ecfdf5; color: #065f46; border-left: 4px solid #10b981 !important;">
    <div class="d-flex align-items-center gap-2">
        <i class="bi bi-check-circle-fill text-success fs-5"></i>
        <span class="fw-medium">{{ session('success') }}</span>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

{{-- Alert error --}}
@if(session('error'))
<div class="alert alert-dismissible fade show border-0 shadow-sm mb-4" role="alert"
    style="border-radius: 12px; background: #fef2f2; color: #991b1b; border-left: 4px solid #ef4444 !important;">
    <div class="d-flex align-items-center gap-2">
        <i class="bi bi-exclamation-circle-fill text-danger fs-5"></i>
        <span class="fw-medium">{{ session('error') }}</span>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

{{-- Header --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">Ajukan Peminjaman Buku</h4>
        <p class="text-muted small mb-0">Pilih buku dan ajukan peminjaman. Admin akan menyetujui pengajuanmu.</p>
    </div>
    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill fw-medium">
        <i class="bi bi-journal-arrow-up me-1"></i>
        {{ $books->where('stok', '>', 0)->count() }} Buku Tersedia
    </span>
</div>


{{-- ======================== STATUS PENGAJUAN SAYA ======================== --}}
@if($pengajuan->count() > 0)
<div class="card border-0 shadow-sm mb-4" style="border-radius: 14px;">
    <div class="card-header border-0 px-4 pt-4 pb-0 bg-transparent">
        <div class="d-flex align-items-center gap-2 mb-3">
            <i class="bi bi-list-check text-success fs-5"></i>
            <h6 class="fw-bold mb-0">Status Pengajuan Saya</h6>
            <span class="badge bg-secondary bg-opacity-10 text-secondary px-2 ms-1" style="font-size: 0.72rem;">
                {{ $pengajuan->count() }} pengajuan
            </span>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr style="background: #f8f9fa;">
                        <th class="ps-4 py-3 text-muted fw-medium border-0" style="font-size: 0.78rem; letter-spacing: 0.4px;">BUKU</th>
                        <th class="py-3 text-muted fw-medium border-0" style="font-size: 0.78rem; letter-spacing: 0.4px;">TGL PINJAM</th>
                        <th class="py-3 text-muted fw-medium border-0" style="font-size: 0.78rem; letter-spacing: 0.4px;">TGL KEMBALI</th>
                        <th class="py-3 pe-4 text-muted fw-medium border-0 text-end" style="font-size: 0.78rem; letter-spacing: 0.4px;">STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pengajuan as $ajuan)
                    <tr>
                        <td class="ps-4 py-3">
                            <div class="d-flex align-items-center gap-3">
                                @if($ajuan->status == 'menunggu')
                                    <div style="width: 38px; height: 38px; border-radius: 10px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; background: rgba(249,115,22,0.1);">
                                        <i class="bi bi-book-fill" style="font-size: 0.9rem; color: #f97316;"></i>
                                    </div>
                                @elseif($ajuan->status == 'dipinjam')
                                    <div style="width: 38px; height: 38px; border-radius: 10px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; background: rgba(29,78,216,0.08);">
                                        <i class="bi bi-book-fill" style="font-size: 0.9rem; color: #1d4ed8;"></i>
                                    </div>
                                @elseif($ajuan->status == 'ditolak')
                                    <div style="width: 38px; height: 38px; border-radius: 10px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; background: rgba(220,38,38,0.08);">
                                        <i class="bi bi-book-fill" style="font-size: 0.9rem; color: #dc2626;"></i>
                                    </div>
                                @else
                                    <div style="width: 38px; height: 38px; border-radius: 10px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; background: rgba(21,128,61,0.1);">
                                        <i class="bi bi-book-fill" style="font-size: 0.9rem; color: #15803d;"></i>
                                    </div>
                                @endif
                                <div>
                                    <div class="fw-semibold text-dark" style="font-size: 0.9rem;">{{ $ajuan->book->judul }}</div>
                                    <div class="text-muted" style="font-size: 0.78rem;">{{ $ajuan->book->penulis }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="text-secondary" style="font-size: 0.85rem;">
                            <i class="bi bi-calendar-event me-1 text-muted"></i>
                            {{ \Carbon\Carbon::parse($ajuan->tanggal_pinjam)->format('d M Y') }}
                        </td>
                        <td class="text-secondary" style="font-size: 0.85rem;">
                            @if($ajuan->tanggal_kembali)
                                <i class="bi bi-calendar-check me-1 text-muted"></i>
                                {{ \Carbon\Carbon::parse($ajuan->tanggal_kembali)->format('d M Y') }}
                            @else
                                <span class="text-muted">---</span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            @if($ajuan->status == 'menunggu')
                                <span class="badge rounded-pill px-3 py-2 fw-medium"
                                    style="background: #fff7ed; color: #c2410c; font-size: 0.75rem;">
                                    <i class="bi bi-hourglass-split me-1"></i> Menunggu Persetujuan
                                </span>
                            @elseif($ajuan->status == 'dipinjam')
                                <span class="badge rounded-pill px-3 py-2 fw-medium"
                                    style="background: #eff6ff; color: #1d4ed8; font-size: 0.75rem;">
                                    <i class="bi bi-check-circle me-1"></i> Disetujui & Dipinjam
                                </span>
                            @elseif($ajuan->status == 'ditolak')
                                <span class="badge rounded-pill px-3 py-2 fw-medium"
                                    style="background: #fef2f2; color: #dc2626; font-size: 0.75rem;">
                                    <i class="bi bi-x-circle me-1"></i> Ditolak
                                </span>
                            @else
                                <span class="badge rounded-pill px-3 py-2 fw-medium"
                                    style="background: #f0fdf4; color: #15803d; font-size: 0.75rem;">
                                    <i class="bi bi-check-all me-1"></i> Dikembalikan
                                </span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif


{{-- ======================== DAFTAR BUKU ======================== --}}
<div class="d-flex align-items-center gap-2 mb-3">
    <h6 class="fw-bold mb-0">Daftar Buku</h6>
    <span class="text-muted small">— pilih buku yang ingin dipinjam</span>
</div>

{{-- Search + Filter (PHP Form GET, tanpa JavaScript) --}}
<div class="card border-0 shadow-sm mb-3" style="border-radius: 14px;">
    <div class="card-body p-3">
        <form action="{{ route('user.books') }}" method="GET">
            <div class="row g-2 align-items-center">
                <div class="col-md-7">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 text-muted">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" name="search" class="form-control border-start-0 ps-0"
                            placeholder="Cari judul buku, penulis, atau penerbit..."
                            value="{{ request('search') }}"
                            style="box-shadow: none;">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="filter" class="form-select" style="box-shadow: none;">
                        <option value="all" {{ request('filter') == 'all' ? 'selected' : '' }}>Semua Buku</option>
                        <option value="tersedia" {{ request('filter') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="habis" {{ request('filter') == 'habis' ? 'selected' : '' }}>Stok Habis</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn w-100 fw-medium"
                        style="background: #198754; color: white; border-radius: 8px; border: none;">
                        <i class="bi bi-search me-1"></i> Cari
                    </button>
                </div>
            </div>
        </form>

        {{-- Tombol reset jika ada filter aktif --}}
        @if(request('search') || (request('filter') && request('filter') != 'all'))
        <div class="mt-2">
            <a href="{{ route('user.books') }}" class="text-decoration-none small text-muted">
                <i class="bi bi-x-circle me-1"></i> Reset pencarian
            </a>
        </div>
        @endif
    </div>
</div>

{{-- Tabel Buku --}}
<div class="card border-0 shadow-sm" style="border-radius: 14px;">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr class="text-muted small" style="background: #f8f9fa;">
                        <th class="fw-medium py-3 ps-4 border-0" style="font-size: 0.78rem; letter-spacing: 0.4px;">NO</th>
                        <th class="fw-medium py-3 border-0" style="font-size: 0.78rem; letter-spacing: 0.4px;">JUDUL BUKU</th>
                        <th class="fw-medium py-3 border-0" style="font-size: 0.78rem; letter-spacing: 0.4px;">PENULIS</th>
                        <th class="fw-medium py-3 border-0" style="font-size: 0.78rem; letter-spacing: 0.4px;">PENERBIT</th>
                        <th class="fw-medium py-3 border-0" style="font-size: 0.78rem; letter-spacing: 0.4px;">TAHUN</th>
                        <th class="fw-medium py-3 border-0 text-center" style="font-size: 0.78rem; letter-spacing: 0.4px;">STOK</th>
                        <th class="fw-medium py-3 border-0 text-center" style="font-size: 0.78rem; letter-spacing: 0.4px;">STATUS</th>
                        <th class="fw-medium py-3 pe-4 border-0 text-center" style="font-size: 0.78rem; letter-spacing: 0.4px;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($books as $book)
                    @php
                        $sudahAjukan = $pengajuan->whereIn('status', ['menunggu', 'dipinjam'])
                            ->where('book_id', $book->id)->count() > 0;
                    @endphp
                    <tr>
                        <td class="ps-4 text-muted">{{ $loop->iteration }}</td>

                        <td>
                            <div class="d-flex align-items-center gap-3">
                                @if($book->stok > 0)
                                    <div style="width: 40px; height: 40px; border-radius: 10px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; background: rgba(25,135,84,0.1);">
                                        <i class="bi bi-book-fill" style="color: #198754;"></i>
                                    </div>
                                @else
                                    <div style="width: 40px; height: 40px; border-radius: 10px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; background: rgba(220,53,69,0.08);">
                                        <i class="bi bi-book-fill" style="color: #dc3545;"></i>
                                    </div>
                                @endif
                                <div>
                                    <div class="fw-semibold text-dark" style="font-size: 0.9rem;">{{ $book->judul }}</div>
                                </div>
                            </div>
                        </td>

                        <td class="text-secondary" style="font-size: 0.88rem;">{{ $book->penulis }}</td>
                        <td class="text-secondary" style="font-size: 0.88rem;">{{ $book->penerbit }}</td>
                        <td class="text-secondary" style="font-size: 0.88rem;">{{ $book->tahun }}</td>

                        <td class="text-center fw-semibold {{ $book->stok > 0 ? 'text-success' : 'text-danger' }}">
                            {{ $book->stok }}
                        </td>

                        <td class="text-center">
                            @if($book->stok > 0)
                                <span class="badge rounded-pill px-3 py-2"
                                    style="background: rgba(25,135,84,0.1); color: #198754; font-size: 0.73rem;">
                                    <i class="bi bi-dot me-1"></i>Tersedia
                                </span>
                            @else
                                <span class="badge rounded-pill px-3 py-2"
                                    style="background: rgba(220,53,69,0.08); color: #dc3545; font-size: 0.73rem;">
                                    <i class="bi bi-dot me-1"></i>Habis
                                </span>
                            @endif
                        </td>

                        <td class="text-center pe-4">
                            @if($sudahAjukan)
                                <span class="badge px-3 py-2 fw-medium"
                                    style="background: #fff7ed; color: #c2410c; border-radius: 8px; font-size: 0.78rem;">
                                    <i class="bi bi-hourglass-split me-1"></i> Sudah Diajukan
                                </span>
                            @elseif($book->stok > 0)
                                {{-- Link ke halaman konfirmasi (tanpa JavaScript) --}}
                                <a href="{{ route('user.konfirmasiPinjam', $book->id) }}"
                                    class="btn btn-sm px-3 py-2 fw-medium"
                                    style="background: #198754; color: white; border-radius: 8px; font-size: 0.82rem; border: none; text-decoration: none;">
                                    <i class="bi bi-send me-1"></i> Ajukan
                                </a>
                            @else
                                <span class="badge px-3 py-2 fw-medium"
                                    style="background: #f8d7da; color: #dc3545; border-radius: 8px; font-size: 0.82rem;">
                                    <i class="bi bi-x-circle me-1"></i> Habis
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary opacity-50"></i>
                            @if(request('search'))
                                <span class="fw-medium">Buku tidak ditemukan untuk "{{ request('search') }}"</span>
                                <p class="small mt-1 mb-0">
                                    <a href="{{ route('user.books') }}" class="text-decoration-none">Lihat semua buku</a>
                                </p>
                            @else
                                <span class="fw-medium">Belum ada buku tersedia</span>
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .book-row { transition: background 0.15s ease; }
    .book-row:hover { background: #fafffe !important; }
    .input-group-text, .form-control, .form-select { border-color: #e9ecef; }
</style>

@endsection
