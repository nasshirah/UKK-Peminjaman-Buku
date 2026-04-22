@extends('layouts.user')

@section('content')

<!-- Animated Welcome Banner -->
<div class="dashboard-banner mb-5 position-relative overflow-hidden shadow-lg" style="border-radius: 24px; background: linear-gradient(135deg, #3b82f6 0%, #10b981 100%); color: white;">
    <!-- Glassmorphism overlay patterns -->
    <div class="glass-bg position-absolute w-100 h-100 top-0 start-0"></div>
    <div class="glow-circle circle-1"></div>
    <div class="glow-circle circle-2"></div>
    
    <div class="card-body p-5 position-relative z-index-1">
        <h3 class="fw-bolder mb-2 display-6" style="letter-spacing: -0.5px;">Hello, {{ session('nama') }}! ✨</h3>
        <p class="fs-5 opacity-75 mb-4 fw-light">Hari yang indah untuk menjelajahi wawasan baru.</p>
        <a href="{{ route('user.books') }}" class="btn btn-light text-primary px-4 py-2 fw-bold shadow-sm rounded-pill btn-hover-scale">
            Mulai Membaca <i class="bi bi-arrow-right ms-2"></i>
        </a>
    </div>
</div>

<div class="row g-4 mb-5">
    <!-- Card Total Buku -->
    <div class="col-md-4">
        <div class="card border-0 premium-stat-card shadow-sm h-100">
            <div class="card-body p-4 position-relative overflow-hidden">
                <div class="d-flex align-items-center justify-content-between mb-4 position-relative z-1">
                    <div class="modern-icon-box" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                        <i class="bi bi-collection-fill text-white fs-4"></i>
                    </div>
                </div>
                <h6 class="text-secondary fw-semibold mb-1 position-relative z-1 text-uppercase" style="letter-spacing: 1px; font-size: 0.75rem;">Total Buku Tersedia</h6>
                <h2 class="fw-bolder mb-0 text-dark display-5 position-relative z-1">{{ $totalBuku }}</h2>
                <div class="decorative-blob bg-success"></div>
            </div>
        </div>
    </div>

    <!-- Card Pinjaman Aktif -->
    <div class="col-md-4">
        <div class="card border-0 premium-stat-card shadow-sm h-100">
            <div class="card-body p-4 position-relative overflow-hidden">
                <div class="d-flex align-items-center justify-content-between mb-4 position-relative z-1">
                    <div class="modern-icon-box" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                        <i class="bi bi-bookmark-check-fill text-white fs-4"></i>
                    </div>
                </div>
                <h6 class="text-secondary fw-semibold mb-1 position-relative z-1 text-uppercase" style="letter-spacing: 1px; font-size: 0.75rem;">Pinjaman & Pengajuan</h6>
                <h2 class="fw-bolder mb-0 text-dark display-5 position-relative z-1">{{ $totalPinjaman }}</h2>
                <div class="decorative-blob bg-primary"></div>
            </div>
        </div>
    </div>

    <!-- Card Total Riwayat -->
    <div class="col-md-4">
        <div class="card border-0 premium-stat-card shadow-sm h-100">
            <div class="card-body p-4 position-relative overflow-hidden">
                <div class="d-flex align-items-center justify-content-between mb-4 position-relative z-1">
                    <div class="modern-icon-box" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                        <i class="bi bi-clock-history text-white fs-4"></i>
                    </div>
                </div>
                <h6 class="text-secondary fw-semibold mb-1 position-relative z-1 text-uppercase" style="letter-spacing: 1px; font-size: 0.75rem;">Total Peminjaman</h6>
                <h2 class="fw-bolder mb-0 text-dark display-5 position-relative z-1">{{ $totalRiwayat }}</h2>
                <div class="decorative-blob bg-warning"></div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 premium-table-card shadow-sm" style="border-radius: 20px;">
    <div class="card-body p-4 p-md-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="fw-bolder mb-1 text-dark">Informasi Terakhir</h5>
                <p class="text-muted small mb-0">Melacak 5 aktivitas peminjaman terbaru Anda.</p>
            </div>
            <a href="{{ route('user.riwayat') }}" class="btn btn-light rounded-pill text-primary fw-bold px-4 hover-glass flex-shrink-0">Lebih Banyak</a>
        </div>
        
        <div class="table-responsive">
            <table class="table align-middle custom-modern-table">
                <thead>
                    <tr>
                        <th class="border-0 fw-bold py-3 px-4 text-uppercase">Buku</th>
                        <th class="border-0 fw-bold py-3 text-uppercase">Tanggal</th>
                        <th class="border-0 fw-bold py-3 px-4 text-end text-uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @forelse($riwayatTerbaru as $item)
                        <tr class="table-row-hover">
                            <td class="fw-semibold py-4 text-dark px-4">
                                <div class="d-flex align-items-center">
                                    <div class="bg-light rounded p-2 me-3 d-flex align-items-center justify-content-center text-primary" style="width:40px; height:40px;">
                                        <i class="bi bi-book"></i>
                                    </div>
                                    {{ $item->book->judul }}
                                </div>
                            </td>
                            <td class="text-secondary fw-medium">{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}</td>
                            <td class="text-end px-4">
                                @if($item->status == 'pending' || $item->status == 'menunggu')
                                    <span class="modern-badge badge-warning">Menunggu</span>
                                @elseif($item->status == 'dipinjam')
                                    <span class="modern-badge badge-primary">Dipinjam</span>
                                @elseif($item->status == 'dikembalikan')
                                    <span class="modern-badge badge-success">Selesai</span>
                                @else
                                    <span class="modern-badge badge-danger">Ditolak</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-5 text-muted fw-medium">Waktu yang tepat untuk mulai meminjam buku!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    /* Premium Styling - Avoid Simple Designs */
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap');
    
    body { font-family: 'Outfit', sans-serif; background-color: #f4f7fb; }
    
    /* Banner Glass & Glow */
    .dashboard-banner {
        transition: transform 0.4s ease, box-shadow 0.4s ease;
    }
    .dashboard-banner:hover {
        transform: translateY(-5px);
        box-shadow: 0 25px 50px rgba(59, 130, 246, 0.3) !important;
    }
    .glass-bg {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        z-index: 0;
    }
    .glow-circle {
        position: absolute; border-radius: 50%; filter: blur(50px); z-index: 0;
    }
    .circle-1 { top: -20%; right: -10%; width: 400px; height: 400px; background: rgba(255,255,255,0.15); }
    .circle-2 { bottom: -20%; left: 0%; width: 300px; height: 300px; background: rgba(0, 255, 128, 0.2); }
    
    .btn-hover-scale { transition: transform 0.2s ease, box-shadow 0.2s ease; }
    .btn-hover-scale:hover { transform: scale(1.05); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }

    /* Stat Cards */
    .premium-stat-card {
        border-radius: 20px !important;
        background: white;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    .premium-stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.06) !important;
    }
    .modern-icon-box {
        width: 56px; height: 56px; border-radius: 16px;
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
    }
    
    /* Decorative Blobs in Cards */
    .decorative-blob {
        position: absolute; right: -20px; bottom: -20px;
        width: 100px; height: 100px; border-radius: 50%; opacity: 0.05;
        transition: transform 0.5s ease;
    }
    .premium-stat-card:hover .decorative-blob { transform: scale(1.5) rotate(45deg); opacity: 0.08;}

    /* Modern Table */
    .premium-table-card { transition: box-shadow 0.3s ease; }
    .custom-modern-table thead th {
        color: #94a3b8; font-size: 0.75rem; letter-spacing: 1px;
        border-bottom: 2px solid #f1f5f9 !important;
    }
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

    .hover-glass { transition: all 0.2s; background: #f8fafc; border: 1px solid #e2e8f0; }
    .hover-glass:hover { background: #f1f5f9; transform: translateY(-2px); }
</style>

@endsection