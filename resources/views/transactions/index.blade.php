@extends('layouts.admin')

@section('page_title', 'Transaksi Peminjaman')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <p class="text-muted small mb-0">Pantau peredaran buku, setujui pengajuan, dan status pengembalian.</p>
    </div>
    <a href="/transactions/create" class="btn fw-semibold px-4"
       style="background-color: #10b981; color: white; border-radius: 10px; border: none;">
        + Pinjam Buku
    </a>
</div>

@if(session('success'))
<div class="alert alert-success border-0 shadow-sm mb-4" style="background-color: #ecfdf5; color: #059669; border-radius: 10px;">
    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert alert-danger border-0 shadow-sm mb-4" style="border-radius: 10px;">
    <i class="bi bi-exclamation-circle-fill me-2"></i> {{ session('error') }}
</div>
@endif

{{-- ========================= PENGAJUAN MENUNGGU ========================= --}}
@php
    $menunggu = $transactions->where('status', 'menunggu');
@endphp

@if($menunggu->count() > 0)
<div class="mb-4">
    <div class="d-flex align-items-center gap-2 mb-3">
        <span class="badge px-3 py-2 rounded-pill fw-semibold"
            style="background: #fff7ed; color: #c2410c; font-size: 0.8rem;">
            <i class="bi bi-hourglass-split me-1"></i>
            {{ $menunggu->count() }} Pengajuan Menunggu Persetujuan
        </span>
    </div>

    <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 15px; border-left: 4px solid #f97316 !important;">
        <div class="card-header border-0 px-4 py-3" style="background: #fff7ed;">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-hourglass-split text-warning fs-5"></i>
                <h6 class="fw-bold mb-0 text-warning" style="color: #c2410c !important;">Pengajuan Menunggu Persetujuan</h6>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr style="background-color: #fffbf5;">
                        <th class="ps-4 py-3 text-muted fw-medium" style="font-size: 0.78rem;">NO</th>
                        <th class="py-3 text-muted fw-medium" style="font-size: 0.78rem;">ANGGOTA</th>
                        <th class="py-3 text-muted fw-medium" style="font-size: 0.78rem;">JUDUL BUKU</th>
                        <th class="py-3 text-muted fw-medium" style="font-size: 0.78rem;">TGL PINJAM</th>
                        <th class="py-3 text-muted fw-medium" style="font-size: 0.78rem;">TGL KEMBALI</th>
                        <th class="pe-4 py-3 text-muted fw-medium text-end" style="font-size: 0.78rem;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($menunggu as $trx)
                    <tr>
                        <td class="ps-4 text-muted">{{ $loop->iteration }}</td>
                        <td>
                            <div class="fw-semibold text-dark">{{ $trx->member->nama }}</div>
                            <div class="text-muted small">{{ $trx->member->email }}</div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div style="width: 32px; height: 32px; background: rgba(249,115,22,0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <i class="bi bi-book-fill" style="color: #f97316; font-size: 0.85rem;"></i>
                                </div>
                                <span class="fw-medium">{{ $trx->book->judul }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="small"><i class="bi bi-calendar-event me-1 text-muted"></i> {{ $trx->tanggal_pinjam }}</div>
                        </td>
                        <td>
                            @if($trx->tanggal_kembali)
                                <div class="small"><i class="bi bi-calendar-check me-1 text-muted"></i> {{ $trx->tanggal_kembali }}</div>
                            @else
                                <span class="text-muted small">---</span>
                            @endif
                        </td>
                        <td class="pe-4 text-end">
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="{{ route('transactions.setujui', $trx->id) }}"
                                   class="btn btn-sm fw-semibold px-3 py-2"
                                   style="background: #ecfdf5; color: #059669; border: 1px solid #059669; border-radius: 8px; font-size: 0.82rem;"
                                   onclick="return confirm('Setujui pengajuan peminjaman dari {{ $trx->member->nama }}?')">
                                    <i class="bi bi-check-lg me-1"></i> Setujui
                                </a>
                                <a href="{{ route('transactions.tolak', $trx->id) }}"
                                   class="btn btn-sm fw-semibold px-3 py-2"
                                   style="background: #fef2f2; color: #dc2626; border: 1px solid #dc2626; border-radius: 8px; font-size: 0.82rem;"
                                   onclick="return confirm('Tolak pengajuan peminjaman dari {{ $trx->member->nama }}?')">
                                    <i class="bi bi-x-lg me-1"></i> Tolak
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif

{{-- ========================= SEMUA TRANSAKSI ========================= --}}
<div class="d-flex align-items-center gap-2 mb-3">
    <h6 class="fw-bold mb-0">Semua Transaksi</h6>
    <span class="badge bg-light text-muted px-2" style="font-size: 0.75rem;">{{ $transactions->count() }} total</span>
</div>

<div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 15px;">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr style="background-color: #f8fafc;">
                    <th class="ps-4 py-3 fw-medium text-muted" style="font-size: 0.78rem;">NO</th>
                    <th class="py-3 fw-medium text-muted" style="font-size: 0.78rem;">ANGGOTA</th>
                    <th class="py-3 fw-medium text-muted" style="font-size: 0.78rem;">JUDUL BUKU</th>
                    <th class="py-3 fw-medium text-muted" style="font-size: 0.78rem;">TGL PINJAM</th>
                    <th class="py-3 fw-medium text-muted" style="font-size: 0.78rem;">TGL KEMBALI</th>
                    <th class="py-3 fw-medium text-muted" style="font-size: 0.78rem;">STATUS</th>
                    <th class="pe-4 py-3 fw-medium text-muted text-end" style="font-size: 0.78rem;">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $trx)
                <tr>
                    <td class="ps-4 text-muted">{{ $loop->iteration }}</td>
                    <td>
                        <span class="fw-semibold text-dark">{{ $trx->member->nama }}</span>
                    </td>
                    <td>
                        <span class="text-secondary">{{ $trx->book->judul }}</span>
                    </td>
                    <td>
                        <div class="small"><i class="bi bi-calendar-event me-1"></i> {{ $trx->tanggal_pinjam }}</div>
                    </td>
                    <td>
                        @if($trx->tanggal_kembali)
                            <div class="small"><i class="bi bi-calendar-check me-1"></i> {{ $trx->tanggal_kembali }}</div>
                        @else
                            <span class="text-muted small">---</span>
                        @endif
                    </td>
                    <td>
                        @if($trx->status == 'menunggu')
                            <span class="badge rounded-pill px-3 py-2" style="background: #fff7ed; color: #c2410c; font-weight: 500; font-size: 0.75rem;">
                                <i class="bi bi-hourglass-split me-1"></i> Menunggu
                            </span>
                        @elseif($trx->status == 'dipinjam')
                            <span class="badge rounded-pill px-3 py-2" style="background-color: #eff6ff; color: #1d4ed8; font-weight: 500; font-size: 0.75rem;">
                                <i class="bi bi-clock-history me-1"></i> Dipinjam
                            </span>
                        @elseif($trx->status == 'ditolak')
                            <span class="badge rounded-pill px-3 py-2" style="background: #fef2f2; color: #dc2626; font-weight: 500; font-size: 0.75rem;">
                                <i class="bi bi-x-circle me-1"></i> Ditolak
                            </span>
                        @else
                            <span class="badge rounded-pill px-3 py-2" style="background-color: #f0fdf4; color: #15803d; font-weight: 500; font-size: 0.75rem;">
                                <i class="bi bi-check-lg me-1"></i> Dikembalikan
                            </span>
                        @endif
                    </td>
                    <td class="pe-4 text-end">
                        @if($trx->status == 'menunggu')
                            <div class="d-flex gap-1 justify-content-end">
                                <a href="{{ route('transactions.setujui', $trx->id) }}"
                                   class="btn btn-sm px-2 py-1"
                                   style="background: #ecfdf5; color: #059669; border: 1px solid #059669; border-radius: 6px; font-size: 0.78rem;"
                                   onclick="return confirm('Setujui?')">
                                    <i class="bi bi-check-lg"></i> Setujui
                                </a>
                                <a href="{{ route('transactions.tolak', $trx->id) }}"
                                   class="btn btn-sm px-2 py-1"
                                   style="background: #fef2f2; color: #dc2626; border: 1px solid #dc2626; border-radius: 6px; font-size: 0.78rem;"
                                   onclick="return confirm('Tolak?')">
                                    <i class="bi bi-x-lg"></i> Tolak
                                </a>
                            </div>
                        @elseif($trx->status == 'dipinjam')
                            <a href="{{ route('transactions.kembali', $trx->id) }}"
                               class="btn btn-sm fw-bold px-3 py-2"
                               style="background-color: #ecfdf5; color: #10b981; border: 1px solid #10b981; border-radius: 8px;"
                               onclick="return confirm('Yakin buku sudah dikembalikan?')">
                                <i class="bi bi-arrow-return-left me-1"></i> Kembali
                            </a>
                        @else
                            <span class="badge bg-light text-muted fw-normal px-3 py-2" style="border-radius: 8px;">
                                <i class="bi bi-check-circle me-1"></i> Selesai
                            </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="bi bi-arrow-left-right fs-1 d-block mb-2 opacity-25"></i>
                        Belum ada transaksi peminjaman.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection