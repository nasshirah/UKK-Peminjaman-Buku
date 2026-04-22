@extends('layouts.user')

@section('title', 'Pengembalian Buku')

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

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">Pengembalian Buku</h4>
        <p class="text-muted small mb-0">Daftar buku yang sedang Anda pinjam. Klik tombol "Kembalikan" untuk mengembalikan buku.</p>
    </div>
    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-medium">
        <i class="bi bi-journal-arrow-down me-1"></i>
        {{ $transactions->where('status', 'dipinjam')->count() }} Buku Dipinjam
    </span>
</div>

<div class="card border-0 shadow-sm mb-4" style="border-radius: 14px;">
    <div class="card-header border-0 px-4 pt-4 pb-0 bg-transparent">
        <div class="d-flex align-items-center gap-2 mb-3">
            <i class="bi bi-journal-arrow-down text-primary fs-5"></i>
            <h6 class="fw-bold mb-0">Pinjaman Aktif</h6>
            <span class="badge bg-secondary bg-opacity-10 text-secondary px-2 ms-1" style="font-size: 0.72rem;">
                {{ $transactions->count() }} data
            </span>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr style="background: #f8f9fa;">
                        <th class="ps-4 py-3 text-muted fw-medium border-0" style="font-size: 0.78rem; letter-spacing: 0.4px;">NO</th>
                        <th class="py-3 text-muted fw-medium border-0" style="font-size: 0.78rem; letter-spacing: 0.4px;">BUKU</th>
                        <th class="py-3 text-muted fw-medium border-0" style="font-size: 0.78rem; letter-spacing: 0.4px;">TGL PINJAM</th>
                        <th class="py-3 text-muted fw-medium border-0" style="font-size: 0.78rem; letter-spacing: 0.4px;">TGL KEMBALI</th>
                        <th class="py-3 text-muted fw-medium border-0 text-center" style="font-size: 0.78rem; letter-spacing: 0.4px;">STATUS</th>
                        <th class="py-3 pe-4 text-muted fw-medium border-0 text-center" style="font-size: 0.78rem; letter-spacing: 0.4px;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $trx)
                    <tr>
                        <td class="ps-4 text-muted">{{ $loop->iteration }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-3 py-2">
                                @if($trx->status == 'dipinjam')
                                <div style="width: 38px; height: 38px; border-radius: 10px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; background: rgba(29,78,216,0.08);">
                                    <i class="bi bi-book-fill" style="font-size: 0.9rem; color: #1d4ed8;"></i>
                                </div>
                                @else
                                <div style="width: 38px; height: 38px; border-radius: 10px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; background: rgba(249,115,22,0.1);">
                                    <i class="bi bi-book-fill" style="font-size: 0.9rem; color: #f97316;"></i>
                                </div>
                                @endif
                                <div>
                                    <div class="fw-semibold text-dark" style="font-size: 0.9rem;">{{ $trx->book->judul }}</div>
                                    <div class="text-muted" style="font-size: 0.78rem;">{{ $trx->book->penulis }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="text-secondary" style="font-size: 0.85rem;">
                            <i class="bi bi-calendar-event me-1 text-muted"></i>
                            {{ \Carbon\Carbon::parse($trx->tanggal_pinjam)->format('d M Y') }}
                        </td>
                        <td class="text-secondary" style="font-size: 0.85rem;">
                            @if($trx->tanggal_kembali)
                                <i class="bi bi-calendar-check me-1 text-muted"></i>
                                {{ \Carbon\Carbon::parse($trx->tanggal_kembali)->format('d M Y') }}
                            @else
                                <span class="text-muted">---</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($trx->status == 'dipinjam')
                                <span class="badge rounded-pill px-3 py-2 fw-medium"
                                    style="background: #eff6ff; color: #1d4ed8; font-size: 0.75rem;">
                                    <i class="bi bi-check-circle me-1"></i> Sedang Dipinjam
                                </span>
                            @elseif($trx->status == 'menunggu')
                                <span class="badge rounded-pill px-3 py-2 fw-medium"
                                    style="background: #fff7ed; color: #c2410c; font-size: 0.75rem;">
                                    <i class="bi bi-hourglass-split me-1"></i> Menunggu
                                </span>
                            @endif
                        </td>
                        <td class="text-center pe-4">
                            @if($trx->status == 'dipinjam')
                                <form action="{{ route('user.kembalikanBuku', $trx->id) }}" method="POST"
                                    onsubmit="return confirm('Apakah Anda yakin ingin mengembalikan buku &quot;{{ $trx->book->judul }}&quot;?')">
                                    @csrf
                                    <button type="submit" class="btn btn-sm px-3 py-2 fw-medium"
                                        style="background: #198754; color: white; border-radius: 8px; font-size: 0.82rem; border: none;">
                                        <i class="bi bi-arrow-return-left me-1"></i> Kembalikan
                                    </button>
                                </form>
                            @elseif($trx->status == 'menunggu')
                                <span class="badge px-3 py-2 fw-medium"
                                    style="background: #f3f4f6; color: #9ca3af; border-radius: 8px; font-size: 0.78rem;">
                                    <i class="bi bi-clock me-1"></i> Belum Disetujui
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary opacity-50"></i>
                            <span class="fw-medium">Belum ada buku yang sedang dipinjam</span>
                            <p class="small mt-1 mb-0">
                                <a href="{{ route('user.books') }}" class="text-decoration-none">Pinjam buku sekarang</a>
                            </p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
