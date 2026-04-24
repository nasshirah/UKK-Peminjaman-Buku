@extends('layouts.user')

@section('title', 'Riwayat Peminjaman')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 pb-2 border-bottom">
    <div>
        <h3 class="fw-bolder text-dark mb-1">Riwayat Peminjaman</h3>
        <p class="text-muted mb-0">Catatan dari semua aktivitas peminjaman buku Anda.</p>
    </div>
    <div class="mt-3 mt-md-0 d-flex gap-2">
        <a href="{{ route('user.riwayat.excel') }}" class="btn btn-outline-success fw-medium rounded-pill px-4 shadow-sm border-2 btn-hover-scale">
            <i class="bi bi-file-earmark-excel me-2"></i> Excel
        </a>
        <a href="{{ route('user.riwayat.pdf') }}" class="btn btn-outline-danger fw-medium rounded-pill px-4 shadow-sm border-2 btn-hover-scale">
            <i class="bi bi-file-earmark-pdf me-2"></i> PDF
        </a>
    </div>
</div>

<div class="card border-0 premium-table-card shadow-sm" style="border-radius: 20px;">
    <div class="card-body p-4 p-md-5">
        <div class="table-responsive">
            <table class="table align-middle custom-modern-table">
                <thead>
                    <tr>
                        <th class="border-0 fw-bold py-3 px-4 text-uppercase">No</th>
                        <th class="border-0 fw-bold py-3 text-uppercase">Buku</th>
                        <th class="border-0 fw-bold py-3 text-uppercase">Tanggal Pinjam</th>
                        <th class="border-0 fw-bold py-3 text-uppercase">Tanggal Kembali</th>
                        <th class="border-0 fw-bold py-3 px-4 text-end text-uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @forelse($transactions as $trx)
                        <tr class="table-row-hover">
                            <td class="text-muted fw-medium px-4">{{ $loop->iteration }}</td>
                            <td class="fw-semibold py-4 text-dark">
                                <div class="d-flex align-items-center">
                                    <div class="bg-light rounded p-2 me-3 d-flex align-items-center justify-content-center text-primary flex-shrink-0" style="width:40px; height:40px;">
                                        <i class="bi bi-journal-text fs-5"></i>
                                    </div>
                                    <span class="text-truncate" style="max-width: 250px;" title="{{ $trx->book->judul }}">{{ $trx->book->judul }}</span>
                                </div>
                            </td>
                            <td class="text-secondary fw-medium">{{ \Carbon\Carbon::parse($trx->tanggal_pinjam)->format('d M Y') }}</td>
                            <td class="text-secondary fw-medium">
                                @if($trx->pengembalian && $trx->pengembalian->status == 'disetujui')
                                    {{ \Carbon\Carbon::parse($trx->pengembalian->tanggal_kembali)->format('d M Y') }}
                                @else
                                    {{ $trx->tanggal_kembali ? \Carbon\Carbon::parse($trx->tanggal_kembali)->format('d M Y') : '—' }}
                                @endif
                            </td>
                            <td class="text-end px-4">
                                @if($trx->status == 'menunggu')
                                    <span class="modern-badge badge-warning">Menunggu</span>
                                @elseif($trx->status == 'dipinjam')
                                    <span class="modern-badge badge-primary">Dipinjam</span>
                                @elseif($trx->status == 'selesai')
                                    <span class="modern-badge badge-success">Selesai</span>
                                @else
                                    <span class="modern-badge badge-danger">Ditolak</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted fw-medium">
                                <div class="empty-state py-4">
                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px;">
                                        <i class="bi bi-clock-history text-muted fs-1"></i>
                                    </div>
                                    Belum ada riwayat peminjaman sama sekali.
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
    
    .btn-hover-scale { transition: all 0.2s ease; }
    .btn-hover-scale:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
    .hover-glass { background: rgba(255, 255, 255, 0.5); backdrop-filter: blur(5px); }
    .hover-glass:hover { background: #fff !important; }

    /* Modern Table */
    .premium-table-card { transition: box-shadow 0.3s ease; border-radius: 20px; }
    .custom-modern-table thead th {
        color: #94a3b8; font-size: 0.75rem; letter-spacing: 1px;
        border-bottom: 2px solid #f1f5f9 !important;
        background-color: #f8fafc;
    }
    .custom-modern-table thead th:first-child { border-top-left-radius: 10px; border-bottom-left-radius: 10px; }
    .custom-modern-table thead th:last-child { border-top-right-radius: 10px; border-bottom-right-radius: 10px; }
    
    .table-row-hover { transition: background-color 0.2s ease; }
    .table-row-hover:hover { background-color: #f8fafc; }
    
    /* Modern Badges */
    .modern-badge {
        padding: 0.5rem 1rem; border-radius: 30px; font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase;
    }
    .badge-primary { background: #eff6ff; color: #3b82f6; }
    .badge-success { background: #ecfdf5; color: #10b981; }
    .badge-warning { background: #fffbeb; color: #f59e0b; }
    .badge-danger  { background: #fef2f2; color: #ef4444; }
</style>
@endsection
