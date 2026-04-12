@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<div class="row g-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="bg-emerald-soft rounded-circle p-3 text-emerald">
                        <i data-lucide="book" style="width: 24px; height: 24px;"></i>
                    </div>
                    <span class="badge bg-success-subtle text-success rounded-pill px-3">Buku</span>
                </div>
                <h6 class="text-secondary fw-medium mb-1">Total Buku</h6>
                <h2 class="fw-bold mb-0">{{ $totalBuku }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="bg-blue-soft rounded-circle p-3 text-primary">
                        <i data-lucide="users" style="width: 24px; height: 24px;"></i>
                    </div>
                    <span class="badge bg-primary-subtle text-primary rounded-pill px-3">Aktif</span>
                </div>
                <h6 class="text-secondary fw-medium mb-1">Total Anggota</h6>
                <h2 class="fw-bold mb-0">{{ $totalAnggota }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="bg-orange-soft rounded-circle p-3 text-warning">
                        <i data-lucide="arrow-up-right" style="width: 24px; height: 24px;"></i>
                    </div>
                    <span class="badge bg-warning-subtle text-warning rounded-pill px-3">Pinjam</span>
                </div>
                <h6 class="text-secondary fw-medium mb-1">Total Peminjaman</h6>
                <h2 class="fw-bold mb-0">{{ $totalPeminjaman }}</h2>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-emerald-soft { background-color: #ecfdf5; }
    .text-emerald { color: #10b981; }
    
    .bg-blue-soft { background-color: #eff6ff; }
    
    .bg-orange-soft { background-color: #fff7ed; }
    
    .card { transition: transform 0.2s ease; }
    .card:hover { transform: translateY(-5px); }
</style>

<script>
    // Memastikan ikon dirender
    lucide.createIcons();
</script>

@endsection