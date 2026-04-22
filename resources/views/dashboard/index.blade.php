@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')

<!-- Welcome Banner -->
<div class="card border-0 shadow-sm mb-4 bg-primary text-white overflow-hidden" style="border-radius: 15px; position: relative;">
    <div class="card-body p-4 p-md-5 z-1 position-relative">
        <h4 class="fw-bold mb-1">Selamat Datang, Admin! 👋</h4>
        <p class="mb-0 opacity-75">Berikut adalah ringkasan sistem e-perpus saat ini.</p>
    </div>
    <!-- Decorative elements -->
    <div style="position: absolute; top: -50%; right: -10%; width: 300px; height: 300px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
    <div style="position: absolute; bottom: -50%; right: 10%; width: 200px; height: 200px; background: rgba(255,255,255,0.05); border-radius: 50%;"></div>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100 stat-card" style="border-radius: 15px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="icon-shape bg-emerald-soft text-emerald rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i data-lucide="book-copy" style="width: 24px; height: 24px;"></i>
                    </div>
                </div>
                <h6 class="text-secondary fw-medium mb-1">Total Buku</h6>
                <h2 class="fw-bold mb-0 text-dark">{{ $totalBuku }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100 stat-card" style="border-radius: 15px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="icon-shape bg-blue-soft text-primary rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i data-lucide="users" style="width: 24px; height: 24px;"></i>
                    </div>
                </div>
                <h6 class="text-secondary fw-medium mb-1">Total Anggota</h6>
                <h2 class="fw-bold mb-0 text-dark">{{ $totalAnggota }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100 stat-card" style="border-radius: 15px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="icon-shape bg-orange-soft text-warning rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i data-lucide="arrow-up-right" style="width: 24px; height: 24px;"></i>
                    </div>
                </div>
                <h6 class="text-secondary fw-medium mb-1">Total Peminjaman</h6>
                <h2 class="fw-bold mb-0 text-dark">{{ $totalPeminjaman }}</h2>
            </div>
        </div>
    </div>
</div>

<!-- Chart Section -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm" style="border-radius: 15px;">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4 text-dark">Grafik Status Transaksi</h5>
                <canvas id="peminjamanChart" height="80"></canvas>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-emerald-soft { background-color: #ecfdf5; }
    .text-emerald { color: #10b981; }
    
    .bg-blue-soft { background-color: #eff6ff; }
    
    .bg-orange-soft { background-color: #fff7ed; }
    
    .stat-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(0,0,0,0.01) !important;
    }
    
    .stat-card:hover { 
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.05) !important;
    }
    
    .icon-shape {
        transition: transform 0.3s ease;
    }
    
    .stat-card:hover .icon-shape {
        transform: scale(1.1) rotate(5deg);
    }
</style>

<!-- Tambahkan Chart.js dari CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Memastikan ikon dirender
    lucide.createIcons();

    // Chart.js Setup
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('peminjamanChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Pending', 'Dipinjam', 'Dikembalikan', 'Ditolak'],
                datasets: [{
                    label: 'Jumlah Transaksi',
                    data: [
                        {{ $grafikStatus['pending'] }},
                        {{ $grafikStatus['dipinjam'] }},
                        {{ $grafikStatus['dikembalikan'] }},
                        {{ $grafikStatus['ditolak'] }}
                    ],
                    backgroundColor: [
                        'rgba(245, 158, 11, 0.85)', // Pending (Orange)
                        'rgba(59, 130, 246, 0.85)', // Dipinjam (Blue)
                        'rgba(16, 185, 129, 0.85)', // Dikembalikan (Green)
                        'rgba(239, 68, 68, 0.85)'   // Ditolak (Red)
                    ],
                    borderRadius: 6,
                    borderSkipped: false,
                    barPercentage: 0.6
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.7)',
                        padding: 10,
                        titleFont: { size: 14 }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            stepSize: 1,
                            font: { size: 12 }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: { size: 13, weight: '500' }
                        }
                    }
                }
            }
        });
    });
</script>

@endsection