@extends('layouts.user')

@section('title', 'Peminjaman Buku')

@section('content')

{{-- Alert notification --}}
@if(session('success'))
<div class="alert alert-dismissible fade show border-0 shadow-lg mb-4" role="alert"
    style="border-radius: 16px; background: #ecfdf5; color: #065f46; border-left: 5px solid #10b981 !important;">
    <div class="d-flex align-items-center gap-3 p-2">
        <i class="bi bi-check-circle-fill fs-4 text-emerald"></i>
        <div class="fw-semibold">{{ session('success') }}</div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-dismissible fade show border-0 shadow-lg mb-4" role="alert"
    style="border-radius: 16px; background: #fef2f2; color: #991b1b; border-left: 5px solid #ef4444 !important;">
    <div class="d-flex align-items-center gap-3 p-2">
        <i class="bi bi-exclamation-circle-fill fs-4 text-danger"></i>
        <div class="fw-semibold">{{ session('error') }}</div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

{{-- Header Section --}}
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 pb-2 border-bottom">
    <div>
        <h3 class="fw-bolder text-dark mb-1">Pinjam Buku</h3>
        <p class="text-muted mb-0">Temukan buku favoritmu dan ajukan peminjaman dengan mudah.</p>
    </div>
    <div class="mt-3 mt-md-0">
        <span class="modern-badge badge-primary shadow-sm px-4 py-2 rounded-pill">
            <i class="bi bi-journal-check me-2"></i> {{ $books->where('stok', '>', 0)->count() }} Buku Tersedia
        </span>
    </div>
</div>

{{-- ======================== SEKSI PENGAJUAN AKTIF ======================== --}}
@if($pengajuan->count() > 0)
<div class="mb-5">
    <div class="d-flex align-items-center gap-2 mb-4">
        <h5 class="fw-bolder text-dark mb-0">Status Pengajuan Terbaru</h5>
        <span class="badge bg-light text-secondary rounded-pill fw-medium">{{ $pengajuan->count() }}</span>
    </div>

    <div class="card border-0 premium-table-card shadow-sm mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle custom-modern-table mb-0">
                    <thead>
                        <tr>
                            <th class="border-0 fw-bold py-3 px-4 text-uppercase">Buku</th>
                            <th class="border-0 fw-bold py-3 text-uppercase">Tgl Pinjam</th>
                            <th class="border-0 fw-bold py-3 text-uppercase">Tgl Kembali</th>
                            <th class="border-0 fw-bold py-3 px-4 text-end text-uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @foreach($pengajuan as $ajuan)
                        <tr class="table-row-hover">
                            <td class="ps-4 py-4">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="modern-icon-box shadow-sm" style="background: #f8fafc; color: #3b82f6;">
                                        <i class="bi bi-book-half fs-5"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $ajuan->book->judul }}</div>
                                        <div class="text-secondary small">{{ $ajuan->book->penulis }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-secondary fw-semibold small">
                                <i class="bi bi-calendar3 me-2 opacity-50"></i>{{ \Carbon\Carbon::parse($ajuan->tanggal_pinjam)->format('d M Y') }}
                            </td>
                            <td class="text-secondary fw-semibold small">
                                @if($ajuan->tanggal_kembali)
                                    <i class="bi bi-check2-circle me-2 opacity-50 text-success"></i>{{ \Carbon\Carbon::parse($ajuan->tanggal_kembali)->format('d M Y') }}
                                @else
                                    <span class="text-muted opacity-50">---</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                @if($ajuan->status == 'menunggu' || $ajuan->status == 'pending')
                                    <span class="modern-badge badge-warning"><i class="bi bi-clock-history me-1"></i> Menunggu</span>
                                @elseif($ajuan->status == 'dipinjam')
                                    <span class="modern-badge badge-primary"><i class="bi bi-check2-all me-1"></i> Dipinjam</span>
                                @elseif($ajuan->status == 'ditolak')
                                    <span class="modern-badge badge-danger"><i class="bi bi-x-circle me-1"></i> Ditolak</span>
                                @else
                                    <span class="modern-badge badge-success"><i class="bi bi-arrow-return-left me-1"></i> Selesai</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endif

{{-- ======================== SEKSI DAFTAR BUKU ======================== --}}
<div class="d-flex align-items-center gap-2 mb-4">
    <h5 class="fw-bolder text-dark mb-0">Daftar Koleksi Tersedia</h5>
</div>

{{-- Modern Search & Filter --}}
<div class="card border-0 shadow-sm mb-4" style="border-radius: 20px;">
    <div class="card-body p-4">
        <form action="{{ route('user.books') }}" method="GET">
            <div class="row g-3">
                <div class="col-lg-7 col-md-6">
                    <div class="input-group modern-input-group shadow-sm">
                        <span class="input-group-text bg-white border-0 ps-3">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" name="search" class="form-control border-0 py-2 ps-2" 
                            placeholder="Judul buku, penulis, atau penerbit..." 
                            value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-lg-3 col-md-4">
                    <div class="input-group modern-input-group shadow-sm">
                        <span class="input-group-text bg-white border-0 ps-3">
                            <i class="bi bi-funnel text-muted"></i>
                        </span>
                        <select name="filter" class="form-select border-0 py-2 ps-2">
                            <option value="all" {{ request('filter') == 'all' ? 'selected' : '' }}>Semua Stok</option>
                            <option value="tersedia" {{ request('filter') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                            <option value="habis" {{ request('filter') == 'habis' ? 'selected' : '' }}>Stok Habis</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2">
                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold rounded-pill shadow-sm btn-hover-scale">
                        Cari
                    </button>
                </div>
            </div>
        </form>
        
        @if(request('search') || (request('filter') && request('filter') != 'all'))
        <div class="mt-3 text-center text-md-start">
            <a href="{{ route('user.books') }}" class="btn btn-link btn-sm text-decoration-none text-muted fw-medium">
                <i class="bi bi-x-lg me-1"></i> Bersihkan filter & cari ulang
            </a>
        </div>
        @endif
    </div>
</div>

{{-- Book Table Section --}}
<div class="card border-0 premium-table-card shadow-sm" style="border-radius: 20px;">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table align-middle custom-modern-table mb-0">
                <thead>
                    <tr>
                        <th class="border-0 fw-bold py-3 px-4 text-uppercase">No</th>
                        <th class="border-0 fw-bold py-3 text-uppercase">Buku</th>
                        <th class="border-0 fw-bold py-3 text-uppercase">Tahun</th>
                        <th class="border-0 fw-bold py-3 text-center text-uppercase">Stok</th>
                        <th class="border-0 fw-bold py-3 text-center text-uppercase px-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @forelse($books as $book)
                    @php
                        $sudahAjukan = $pengajuan->whereIn('status', ['menunggu', 'dipinjam', 'pending'])
                            ->where('book_id', $book->id)->count() > 0;
                    @endphp
                    <tr class="table-row-hover">
                        <td class="px-4 text-muted small fw-medium">{{ $loop->iteration }}</td>
                        <td class="py-4">
                            <div class="d-flex align-items-center gap-3">
                                <div class="modern-icon-box" style="background: rgba(16,185,129,0.08); color: #10b981;">
                                    <i class="bi bi-book fs-5"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">{{ $book->judul }}</div>
                                    <div class="text-secondary small">{{ $book->penulis }} • {{ $book->penerbit }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="text-secondary fw-semibold small">{{ $book->tahun }}</td>
                        <td class="text-center">
                            @if($book->stok > 0)
                                <div class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2 fw-bold" style="font-size: 0.85rem;">
                                    {{ $book->stok }}
                                </div>
                            @else
                                <div class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-2 fw-bold" style="font-size: 0.85rem;">
                                    0
                                </div>
                            @endif
                        </td>
                        <td class="text-center px-4">
                            @if($sudahAjukan)
                                <span class="modern-badge badge-warning px-4">Sudah Diajukan</span>
                            @elseif($book->stok > 0)
                                <a href="{{ route('user.konfirmasiPinjam', $book->id) }}" class="btn btn-primary btn-sm rounded-pill px-4 fw-bold shadow-sm btn-hover-scale">
                                    <i class="bi bi-send-fill me-1"></i> Ajukan
                                </a>
                            @else
                                <button class="btn btn-light btn-sm rounded-pill px-4 fw-bold disabled opacity-50" disabled>
                                    Stok Habis
                                </button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-5 text-center">
                            <div class="empty-state py-4 text-center">
                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px;">
                                    <i class="bi bi-inbox text-muted fs-1"></i>
                                </div>
                                <h6 class="fw-bolder">Data Tidak Ditemukan</h6>
                                <p class="text-muted small">Coba cari dengan kata kunci lain atau bersihkan filter.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap');
    body { font-family: 'Outfit', sans-serif; background-color: #f4f7fb; }

    .btn-hover-scale { transition: all 0.3s ease; }
    .btn-hover-scale:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(59, 130, 246, 0.2); }

    /* Modern Text Emerald */
    .text-emerald { color: #10b981; }

    /* Modern Table Card */
    .premium-table-card { border-radius: 20px; border: none; overflow: hidden; }
    .custom-modern-table thead th {
        background: #f8fafc;
        color: #94a3b8;
        font-size: 0.72rem;
        letter-spacing: 1.2px;
        padding-top: 1.2rem;
        padding-bottom: 1.2rem;
        border-bottom: 1px solid #f1f5f9 !important;
    }
    .table-row-hover { transition: background 0.2s ease; }
    .table-row-hover:hover { background: #f8fafc; }

    /* Icon Box */
    .modern-icon-box {
        width: 44px; height: 44px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }

    /* Input Group refinement */
    .modern-input-group {
        border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }
    .modern-input-group:focus-within {
        border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    .modern-input-group .form-control:focus, .modern-input-group .form-select:focus {
        box-shadow: none;
    }

    /* Badges Style */
    .modern-badge {
        display: inline-flex; align-items: center; justify-content: center;
        padding: 0.5rem 1.25rem; border-radius: 100px;
        font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px;
        text-transform: uppercase;
    }
    .badge-primary { background: #eff6ff; color: #3b82f6; }
    .badge-success { background: #ecfdf5; color: #10b981; }
    .badge-warning { background: #fff7ed; color: #f97316; }
    .badge-danger  { background: #fef2f2; color: #ef4444; }
</style>

@endsection
