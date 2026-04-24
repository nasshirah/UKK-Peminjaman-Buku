@extends('layouts.user')

@section('title', 'Pengembalian')

@section('content')

{{-- Alert sukses --}}
@if(session('success'))
<div class="alert alert-dismissible fade show border-0 shadow-sm mb-4" role="alert"
    style="border-radius: 14px; background: #ecfdf5; color: #065f46; border-left: 5px solid #10b981 !important;">
    <div class="d-flex align-items-center gap-2">
        <i class="bi bi-check-circle-fill text-success fs-5"></i>
        <span class="fw-medium">{{ session('success') }}</span>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

{{-- Header --}}
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 pb-2 border-bottom">
    <div>
        <h3 class="fw-bolder text-dark mb-1">Data Pengembalian</h3>
        <p class="text-muted mb-0">Buku yang sedang dipinjam dan riwayat pengembalian.</p>
    </div>
    <div class="mt-3 mt-md-0">
        @if($pinjamanAktif->count() > 0)
        <span class="modern-badge badge-warning shadow-sm px-4 py-2 rounded-pill">
            <i class="bi bi-journal-arrow-down me-2"></i>{{ $pinjamanAktif->count() }} Buku Harus Dikembalikan
        </span>
        @else
        <span class="modern-badge badge-success shadow-sm px-4 py-2 rounded-pill">
            <i class="bi bi-check-circle me-2"></i>Semua Buku Telah Dikembalikan
        </span>
        @endif
    </div>
</div>

{{-- ========================= TABEL DATA PENGEMBALIAN ========================= --}}
<div class="card border-0 shadow-sm mb-5" style="border-radius: 16px; overflow: hidden;">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr style="background: #f8fafc;">
                        <th class="ps-4 py-3 border-0" style="color:#94a3b8; font-size:0.72rem; letter-spacing:0.8px; text-transform:uppercase;">No</th>
                        <th class="py-3 border-0"       style="color:#94a3b8; font-size:0.72rem; letter-spacing:0.8px; text-transform:uppercase;">Buku</th>
                        <th class="py-3 border-0"       style="color:#94a3b8; font-size:0.72rem; letter-spacing:0.8px; text-transform:uppercase;">Tgl Pinjam</th>
                        <th class="py-3 border-0"       style="color:#94a3b8; font-size:0.72rem; letter-spacing:0.8px; text-transform:uppercase;">Tgl Kembali</th>
                        <th class="py-3 border-0 text-center" style="color:#94a3b8; font-size:0.72rem; letter-spacing:0.8px; text-transform:uppercase;">Status</th>
                        <th class="py-3 pe-4 border-0 text-center" style="color:#94a3b8; font-size:0.72rem; letter-spacing:0.8px; text-transform:uppercase;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $semuaData = $pinjamanAktif->concat($semuaPengembalian);
                    @endphp
                    @forelse($semuaData as $trx)
                    <tr>
                        <td class="ps-4 text-muted small">{{ $loop->iteration }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-3 py-2">
                                <div style="width:40px; height:40px; border-radius:10px; flex-shrink:0; display:flex; align-items:center; justify-content:center; background:{{ $trx->status == 'selesai' ? 'rgba(21,128,61,0.08)' : 'rgba(29,78,216,0.08)' }};">
                                    <i class="bi bi-book-fill" style="color:{{ $trx->status == 'selesai' ? '#15803d' : '#1d4ed8' }}; font-size:0.9rem;"></i>
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
                            @if($trx->pengembalian && $trx->pengembalian->status == 'disetujui')
                                <span class="text-secondary">
                                    <i class="bi bi-calendar-check me-1 text-success opacity-75"></i>
                                    {{ \Carbon\Carbon::parse($trx->pengembalian->tanggal_kembali)->format('d M Y') }}
                                </span>
                            @elseif($trx->pengembalian && $trx->pengembalian->status == 'menunggu')
                                <span class="text-warning small">Menunggu Persetujuan</span>
                            @else
                                <span class="text-muted opacity-75">—</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($trx->status == 'dipinjam')
                                @if($trx->pengembalian && $trx->pengembalian->status == 'menunggu')
                                    <span class="badge rounded-pill px-3 py-2 fw-medium" style="background:#fff7ed; color:#c2410c; font-size:0.75rem;">
                                        <i class="bi bi-hourglass-split me-1"></i>Proses Kembali
                                    </span>
                                @else
                                    <span class="badge rounded-pill px-3 py-2 fw-medium" style="background:#eff6ff; color:#1d4ed8; font-size:0.75rem;">
                                        <i class="bi bi-clock-history me-1"></i>Dipinjam
                                    </span>
                                @endif
                            @elseif($trx->status == 'selesai')
                                <span class="badge rounded-pill px-3 py-2 fw-medium" style="background:#f0fdf4; color:#15803d; font-size:0.75rem;">
                                    <i class="bi bi-check-lg me-1"></i>Dikembalikan
                                </span>
                            @endif
                        </td>
                        <td class="text-center pe-4">
                            @if($trx->status == 'dipinjam' && (!$trx->pengembalian || $trx->pengembalian->status != 'menunggu'))
                                <a href="{{ route('user.konfirmasiKembali', $trx->id) }}" class="btn btn-sm fw-medium px-3 py-2 btn-kembalikan" style="background:#059669; color:white; border-radius:8px; font-size:0.82rem; text-decoration:none;">
                                    <i class="bi bi-arrow-return-left me-1"></i>Kembalikan
                                </a>
                            @elseif($trx->pengembalian && $trx->pengembalian->status == 'menunggu')
                                <span class="badge bg-light text-warning fw-normal px-3 py-2" style="border-radius: 8px;">
                                    <i class="bi bi-hourglass-split me-1"></i> Menunggu Admin
                                </span>
                            @else
                                <span class="badge bg-light text-muted fw-normal px-3 py-2" style="border-radius: 8px;">
                                    <i class="bi bi-check-circle me-1"></i> Selesai
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bi bi-arrow-return-left fs-1 d-block mb-2 opacity-25"></i>
                            Belum ada data pengembalian.
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
    .btn-kembalikan { transition: all 0.2s ease; }
    .btn-kembalikan:hover { filter: brightness(1.1); transform: translateY(-1px); box-shadow: 0 6px 16px rgba(5,150,105,0.25); }
    .modern-badge {
        display: inline-flex; align-items: center; justify-content: center;
        padding: 0.45rem 1.1rem; border-radius: 100px;
        font-size: 0.75rem; font-weight: 700; letter-spacing: 0.4px;
    }
    .badge-success { background: #ecfdf5; color: #059669; }
    .badge-warning { background: #fffbeb; color: #b45309; }
</style>

@endsection
