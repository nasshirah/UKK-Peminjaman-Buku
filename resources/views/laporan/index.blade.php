@extends('layouts.admin')

@section('title', 'Laporan Peminjaman')

@section('content')

{{-- Clean Modern Header --}}
<div class="mb-4">
    <h4 class="fw-bolder text-dark mb-1">Laporan Peminjaman</h4>
    <p class="text-muted small">Kelola dan ekspor data transaksi perpustakaan Anda secara efisien.</p>
</div>

{{-- Statistik Ringkasan Modern & Simpel --}}
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100 modern-card">
            <div class="card-body p-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="modern-icon-container bg-success-light text-success">
                        <i class="bi bi-arrow-left-right"></i>
                    </div>
                    <div>
                        <div class="text-secondary x-small fw-bold text-uppercase tracking-wider">Total</div>
                        <h4 class="fw-bolder mb-0">{{ $totalTransaksi }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100 modern-card">
            <div class="card-body p-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="modern-icon-container bg-primary-light text-primary">
                        <i class="bi bi-book"></i>
                    </div>
                    <div>
                        <div class="text-secondary x-small fw-bold text-uppercase tracking-wider">Pinjam</div>
                        <h4 class="fw-bolder mb-0">{{ $totalDipinjam }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100 modern-card">
            <div class="card-body p-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="modern-icon-container bg-success-light text-success">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div>
                        <div class="text-secondary x-small fw-bold text-uppercase tracking-wider">Selesai</div>
                        <h4 class="fw-bolder mb-0 text-success">{{ $totalDikembalikan }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100 modern-card">
            <div class="card-body p-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="modern-icon-container bg-warning-light text-warning">
                        <i class="bi bi-hourglass-split"></i>
                    </div>
                    <div>
                        <div class="text-secondary x-small fw-bold text-uppercase tracking-wider">Menunggu</div>
                        <h4 class="fw-bolder mb-0 text-warning">{{ $totalMenunggu }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Filter Section Modern --}}
<div class="card border-0 shadow-sm mb-4 search-card">
    <div class="card-body p-4">
        <form action="{{ route('laporan.index') }}" method="GET">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label x-small fw-bolder text-muted text-uppercase mb-2">Mulai</label>
                    <div class="modern-input">
                        <i class="bi bi-calendar-event me-2"></i>
                        <input type="date" name="dari" class="border-0 bg-transparent w-100" value="{{ $dari }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label x-small fw-bolder text-muted text-uppercase mb-2">Sampai</label>
                    <div class="modern-input">
                        <i class="bi bi-calendar-check me-2"></i>
                        <input type="date" name="sampai" class="border-0 bg-transparent w-100" value="{{ $sampai }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label x-small fw-bolder text-muted text-uppercase mb-2">Status</label>
                    <div class="modern-input">
                        <i class="bi bi-filter-circle me-2"></i>
                        <select name="status" class="border-0 bg-transparent w-100 outline-none">
                            <option value="semua" {{ $status == 'semua' ? 'selected' : '' }}>Semua Status</option>
                            <option value="menunggu" {{ $status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                            <option value="dipinjam" {{ $status == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                            <option value="dikembalikan" {{ $status == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                            <option value="ditolak" {{ $status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-dark fw-bold px-4 rounded-pill flex-grow-1 shadow-sm transition-all hover-up">
                        <i class="bi bi-search me-2"></i>Filter
                    </button>
                    <a href="{{ route('laporan.index') }}" class="btn btn-light rounded-circle shadow-sm">
                        <i class="bi bi-arrow-clockwise"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Export Bar --}}
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
    <div class="mb-3 mb-md-0 d-flex align-items-center gap-2">
        <span class="badge bg-soft-dark text-dark px-3 py-2 rounded-pill fw-bold">
            {{ $transactions->count() }} Data Ditemukan
        </span>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('laporan.excel', ['dari' => $dari, 'sampai' => $sampai, 'status' => $status]) }}" class="btn btn-success-soft btn-sm px-3 rounded-pill fw-bold border-0">
            <i class="bi bi-file-earmark-excel me-1"></i> Excel
        </a>
        <a href="{{ route('laporan.pdf', ['dari' => $dari, 'sampai' => $sampai, 'status' => $status]) }}" class="btn btn-danger-soft btn-sm px-3 rounded-pill fw-bold border-0">
            <i class="bi bi-file-earmark-pdf me-1"></i> PDF
        </a>
    </div>
</div>

{{-- Simple Modern Table --}}
<div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 20px;">
    <div class="table-responsive">
        <table class="table align-middle modern-table mb-0">
            <thead>
                <tr>
                    <th class="ps-4 py-4 text-muted x-small fw-bolder text-uppercase tracking-wider border-0 bg-light">No</th>
                    <th class="py-4 text-muted x-small fw-bolder text-uppercase tracking-wider border-0 bg-light">Anggota</th>
                    <th class="py-4 text-muted x-small fw-bolder text-uppercase tracking-wider border-0 bg-light">Buku</th>
                    <th class="py-4 text-muted x-small fw-bolder text-uppercase tracking-wider border-0 bg-light text-center">Pinjam / Kembali</th>
                    <th class="pe-4 py-4 text-muted x-small fw-bolder text-uppercase tracking-wider border-0 bg-light text-end">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $trx)
                <tr class="table-row">
                    <td class="ps-4 text-muted small fw-bold">{{ $loop->iteration }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar-sm bg-light text-primary fw-bolder d-flex align-items-center justify-content-center rounded-circle">
                                {{ strtoupper(substr($trx->member->nama, 0, 1)) }}
                            </div>
                            <div>
                                <div class="fw-bold text-dark small">{{ $trx->member->nama }}</div>
                                <div class="text-muted x-small">{{ $trx->member->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="fw-bold text-dark small mb-0">{{ $trx->book->judul }}</div>
                        <div class="text-muted x-small">{{ $trx->book->penulis }}</div>
                    </td>
                    <td class="text-center">
                        <div class="d-inline-flex align-items-center gap-2 bg-light px-3 py-1 rounded-pill x-small fw-bold text-secondary">
                            <span>{{ \Carbon\Carbon::parse($trx->tanggal_pinjam)->format('d M') }}</span>
                            <i class="bi bi-arrow-right text-muted opacity-50"></i>
                            <span>
                                @if($trx->pengembalian && $trx->status == 'selesai')
                                    {{ \Carbon\Carbon::parse($trx->pengembalian->tanggal_kembali)->format('d M') }}
                                @else
                                    {{ $trx->tanggal_kembali ? \Carbon\Carbon::parse($trx->tanggal_kembali)->format('d M') : '---' }}
                                @endif
                            </span>
                        </div>
                    </td>
                    <td class="pe-4 text-end">
                        @if($trx->status == 'menunggu')
                            <span class="status-badge bg-soft-warning text-warning">Menunggu</span>
                        @elseif($trx->status == 'dipinjam')
                            <span class="status-badge bg-soft-primary text-primary">Dipinjam</span>
                        @elseif($trx->status == 'ditolak')
                            <span class="status-badge bg-soft-danger text-danger">Ditolak</span>
                        @else
                            <span class="status-badge bg-soft-success text-success">Selesai</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-5 text-center text-muted small fw-medium">
                        <i class="bi bi-cloud-slash fs-2 d-block mb-2 opacity-25"></i>
                        Data tidak ditemukan dalam rentang waktu ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap');
    
    :root {
        --primary-light: #eff6ff;
        --success-light: #f0fdf4;
        --warning-light: #fffbeb;
        --danger-light: #fef2f2;
    }

    body { font-family: 'Outfit', sans-serif; background-color: #f8fafc; }
    .x-small { font-size: 12.5px; }
    .tracking-wider { letter-spacing: 0.08em; }

    /* Modern Components */
    .modern-card { border-radius: 16px; border: 1px solid rgba(0,0,0,0.02) !important; transition: all 0.2s ease; }
    .modern-icon-container {
        width: 42px; height: 42px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center; font-size: 1.25rem;
    }

    .bg-primary-light { background-color: var(--primary-light); }
    .bg-success-light { background-color: var(--success-light); }
    .bg-warning-light { background-color: var(--warning-light); }

    .search-card { border-radius: 18px; }
    .modern-input {
        background: #f1f5f9; border-radius: 10px; padding: 8px 12px;
        display: flex; align-items: center; border: 2px solid transparent; transition: all 0.3s;
    }
    .modern-input:focus-within { border-color: #cbd5e1; background: #fff; }
    .modern-input input, .modern-input select { outline: none; font-size: 14px; font-weight: 500; }

    .avatar-sm { width: 34px; height: 34px; font-size: 0.85rem; }
    .bg-soft-dark { background: #f1f5f9; }
    
    .status-badge {
        padding: 6px 16px; border-radius: 50px; font-size: 11.5px; font-weight: 800;
        text-transform: uppercase; letter-spacing: 0.5px; display: inline-block;
    }
    .bg-soft-primary { background: #e0f2fe; }
    .bg-soft-success { background: #dcfce7; }
    .bg-soft-warning { background: #fef3c7; }
    .bg-soft-danger { background: #fee2e2; }

    .btn-success-soft { background: #dcfce7; color: #15803d; }
    .btn-danger-soft { background: #fee2e2; color: #b91c1c; }

    .modern-table tr { border-bottom: 1px solid #f1f5f9; }
    .table-row { transition: all 0.2s; }
    .table-row:hover { background: #f8fafc; }

    .hover-up:hover { transform: translateY(-2px); }
    .transition-all { transition: all 0.3s; }
    .outline-none { outline: none; }
</style>

@endsection
