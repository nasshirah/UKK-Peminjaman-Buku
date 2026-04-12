@extends('layouts.user')

@section('content')
<div class="mb-4">
    <h4 class="fw-bold text-dark">Ringkasan Aktivitas</h4>
    <p class="text-muted small">Selamat datang kembali! Berikut adalah status perpustakaan Anda hari ini.</p>
</div>

<div class="row g-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted small fw-medium mb-1">Total Buku</p>
                        <h3 class="fw-bold mb-0">{{ $totalBuku }}</h3>
                    </div>
                    <div class="p-2 bg-success bg-opacity-10 rounded-3 text-success">
                        <i class="bi bi-collection fs-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted small fw-medium mb-1">Pinjaman Aktif</p>
                        <h3 class="fw-bold mb-0">{{ $totalPinjaman }}</h3>
                    </div>
                    <div class="p-2 bg-primary bg-opacity-10 rounded-3 text-primary">
                        <i class="bi bi-bookmark-check fs-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted small fw-medium mb-1">Buku Tersedia</p>
                        <h3 class="fw-bold mb-0 text-info">{{ $bukuTersedia ?? ($totalBuku - $totalPinjaman) }}</h3>
                    </div>
                    <div class="p-2 bg-info bg-opacity-10 rounded-3 text-info">
                        <i class="bi bi-check-circle fs-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted small fw-medium mb-1">Total Riwayat</p>
                        <h3 class="fw-bold mb-0">{{ $totalRiwayat ?? 0 }}</h3>
                    </div>
                    <div class="p-2 bg-secondary bg-opacity-10 rounded-3 text-secondary">
                        <i class="bi bi-clock-history fs-5"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm mt-4" style="border-radius: 12px;">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h6 class="fw-bold mb-0">Informasi Terakhir</h6>
            <a href="#" class="btn btn-sm btn-light text-muted fw-medium px-3">Lihat Semua</a>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr class="text-muted small">
                        <th class="border-0 fw-medium pb-3">NAMA BUKU</th>
                        <th class="border-0 fw-medium pb-3">TANGGAL AKTIVITAS</th>
                        <th class="border-0 fw-medium pb-3 text-end">STATUS</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    <tr>
                        <td class="fw-semibold py-3 text-dark">Dasar-dasar Pemrograman</td>
                        <td class="text-secondary">{{ date('d M Y') }}</td>
                        <td class="text-end">
                            <span class="badge rounded-pill px-3 py-2 bg-success bg-opacity-10 text-success fw-medium">
                                <i class="bi bi-dot me-1"></i>Sedang Dipinjam
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    /* Tambahan style sederhana untuk memperhalus */
    .card { transition: transform 0.2s ease; }
    .card:hover { transform: translateY(-3px); }
    .table thead th { letter-spacing: 0.5px; }
    .badge { font-size: 0.75rem; letter-spacing: 0.3px; }
</style>
@endsection