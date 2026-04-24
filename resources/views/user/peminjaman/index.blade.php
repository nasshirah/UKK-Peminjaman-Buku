@extends('layouts.user')

@section('title', 'Peminjaman')

@section('content')

{{-- Alert sukses --}}
@if(session('success'))
<div class="alert alert-dismissible fade show border-0 shadow-sm mb-4" role="alert"
    style="border-radius: 14px; background: #ecfdf5; color: #065f46; border-left: 5px solid #10b981 !important;">
    <div class="d-flex align-items-center gap-3 p-1">
        <i class="bi bi-check-circle-fill fs-5" style="color: #10b981;"></i>
        <div class="fw-semibold">{{ session('success') }}</div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

{{-- Alert error --}}
@if(session('error'))
<div class="alert alert-dismissible fade show border-0 shadow-sm mb-4" role="alert"
    style="border-radius: 14px; background: #fef2f2; color: #991b1b; border-left: 5px solid #ef4444 !important;">
    <div class="d-flex align-items-center gap-3 p-1">
        <i class="bi bi-exclamation-circle-fill fs-5 text-danger"></i>
        <div class="fw-semibold">{{ session('error') }}</div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

{{-- Header --}}
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 pb-2 border-bottom">
    <div>
        <h3 class="fw-bolder text-dark mb-1">Data Peminjaman</h3>
        <p class="text-muted mb-0">Semua data peminjaman buku Anda.</p>
    </div>
    <div class="mt-3 mt-md-0">
        <span class="badge rounded-pill px-3 py-2" style="font-size: 0.78rem; background:#f1f5f9; color:#64748b;">
            {{ $semuaPeminjaman->count() }} total
        </span>
    </div>
</div>

{{-- ========================= TABEL DATA PEMINJAMAN ========================= --}}
<div class="card border-0 shadow-sm mb-5" style="border-radius: 16px; overflow: hidden;">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr style="background: #f8fafc;">
                        <th class="ps-4 py-3 border-0" style="color:#94a3b8; font-size:0.72rem; letter-spacing:0.8px; text-transform:uppercase;">No</th>
                        <th class="py-3 border-0"       style="color:#94a3b8; font-size:0.72rem; letter-spacing:0.8px; text-transform:uppercase;">Buku</th>
                        <th class="py-3 border-0"       style="color:#94a3b8; font-size:0.72rem; letter-spacing:0.8px; text-transform:uppercase;">Tgl Pinjam</th>
                        <th class="py-3 border-0"       style="color:#94a3b8; font-size:0.72rem; letter-spacing:0.8px; text-transform:uppercase;">Jatuh Tempo</th>
                        <th class="py-3 pe-4 border-0 text-center" style="color:#94a3b8; font-size:0.72rem; letter-spacing:0.8px; text-transform:uppercase;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($semuaPeminjaman as $trx)
                    <tr>
                        <td class="ps-4 text-muted small">{{ $loop->iteration }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-3 py-2">
                                <div style="width:40px; height:40px; border-radius:10px; flex-shrink:0; display:flex; align-items:center; justify-content:center; background:rgba(29,78,216,0.08);">
                                    <i class="bi bi-book-fill" style="color:#1d4ed8; font-size:0.9rem;"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold text-dark" style="font-size:0.9rem;">{{ $trx->book->judul }}</div>
                                    <div class="text-muted" style="font-size:0.78rem;">{{ $trx->book->penulis }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="text-secondary" style="font-size:0.85rem;">
                            <i class="bi bi-calendar-event me-1 text-muted opacity-75"></i>
                            {{ \Carbon\Carbon::parse($trx->tanggal_pinjam)->format('d M Y') }}
                        </td>
                        <td style="font-size:0.85rem;">
                            @if($trx->tanggal_kembali)
                                <span class="text-secondary">
                                    <i class="bi bi-calendar-check me-1 opacity-75"></i>
                                    {{ \Carbon\Carbon::parse($trx->tanggal_kembali)->format('d M Y') }}
                                </span>
                            @else
                                <span class="text-muted opacity-75">—</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($trx->status == 'dipinjam')
                                <span class="badge rounded-pill px-3 py-2 fw-medium" style="background:#eff6ff; color:#1d4ed8; font-size:0.75rem;">
                                    <i class="bi bi-check-circle me-1"></i>Dipinjam
                                </span>
                            @elseif($trx->status == 'menunggu')
                                <span class="badge rounded-pill px-3 py-2 fw-medium" style="background:#fff7ed; color:#c2410c; font-size:0.75rem;">
                                    <i class="bi bi-hourglass-split me-1"></i>Menunggu
                                </span>
                            @elseif($trx->status == 'ditolak')
                                <span class="badge rounded-pill px-3 py-2 fw-medium" style="background:#fef2f2; color:#dc2626; font-size:0.75rem;">
                                    <i class="bi bi-x-circle me-1"></i>Ditolak
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="bi bi-journal-check fs-1 d-block mb-2 opacity-25"></i>
                            Belum ada data peminjaman.
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
    .modern-badge {
        display: inline-flex; align-items: center; justify-content: center;
        padding: 0.45rem 1.1rem; border-radius: 100px;
        font-size: 0.75rem; font-weight: 700; letter-spacing: 0.4px;
    }
    .badge-success { background: #ecfdf5; color: #059669; }
    .badge-warning { background: #fffbeb; color: #b45309; }
</style>

@endsection
