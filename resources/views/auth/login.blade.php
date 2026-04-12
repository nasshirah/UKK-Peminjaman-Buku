@extends('layouts.auth')

@section('title', 'Login Perpustakaan')

@section('content')

    <div class="text-center mb-4">
        <div class="d-inline-flex justify-content-center align-items-center rounded-4 mb-3 icon-box" 
             style="width: 64px; height: 64px; color: white;">
            <i data-lucide="library" style="width: 32px; height: 32px;"></i>
        </div>
        
        <h4 class="fw-bold text-dark mb-1">Selamat Datang</h4>
        <p class="text-muted small">Kelola koleksi buku dengan mudah dan cepat</p>
    </div>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show small border-0 rounded-3 d-flex align-items-center mb-4" 
             style="background-color: #fff1f2; color: #991b1b;" role="alert">
            <i data-lucide="alert-circle" class="me-2" style="width: 18px;"></i>
            <div>{{ session('error') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="font-size: 0.5rem;"></button>
        </div>
    @endif

    <form method="POST" action="{{ route('login.process') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label text-dark fw-medium small mb-1">Alamat Email</label>
            <div class="input-group">
                <span class="input-group-text border-end-0" style="background-color: #f8fafc;">
                    <i data-lucide="mail" style="width: 18px;"></i>
                </span>
                <input 
                    type="email" 
                    name="email" 
                    class="form-control border-start-0 ps-0" 
                    placeholder="nama@email.com"
                    required
                >
            </div>
        </div>

        <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <label class="form-label text-dark fw-medium small mb-1">Kata Sandi</label>
            </div>
            <div class="input-group">
                <span class="input-group-text border-end-0" style="background-color: #f8fafc;">
                    <i data-lucide="lock" style="width: 18px;"></i>
                </span>
                <input 
                    type="password" 
                    name="password" 
                    class="form-control border-start-0 ps-0" 
                    placeholder="••••••••"
                    required
                >
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold shadow-sm">
            Masuk Sekarang
        </button>
    </form>

    <script>
      // Inisialisasi ulang icon jika diperlukan (opsional karena sudah ada di auth)
      lucide.createIcons();
    </script>

@endsection