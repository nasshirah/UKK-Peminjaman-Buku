@extends('layouts.user')

@section('title', 'Konfirmasi Pengembalian')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
    <div>
        <h3 class="fw-bold text-dark mb-1">Konfirmasi Pengembalian</h3>
        <p class="text-muted small mb-0">Pastikan detail buku sudah benar sebelum mengembalikan.</p>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card border-0 shadow-sm" style="border-radius: 16px; overflow: hidden;">
            <div class="card-header border-0 px-4 pt-4 pb-3 bg-white text-center">
                <div class="mx-auto mb-3" style="width:64px; height:64px; border-radius:16px; background:#eff6ff; display:flex; align-items:center; justify-content:center;">
                    <i class="bi bi-book-half" style="color:#1d4ed8; font-size:2rem;"></i>
                </div>
                <h5 class="fw-bold text-dark mb-1">{{ $trx->book->judul }}</h5>
                <p class="text-muted mb-0">{{ $trx->book->penulis }}</p>
            </div>
            
            <div class="card-body p-4 bg-light">
                <div class="bg-white p-3 rounded-3 shadow-sm mb-4">
                    <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                        <span class="text-muted small">Tanggal Pinjam</span>
                        <span class="fw-medium text-dark small">{{ \Carbon\Carbon::parse($trx->tanggal_pinjam)->format('d F Y') }}</span>
                    </div>
                    <div class="d-flex justify-content-between border-bottom pb-2 mb-2">
                        <span class="text-muted small">Jatuh Tempo</span>
                        <span class="fw-medium text-dark small">{{ \Carbon\Carbon::parse($trx->tanggal_kembali)->format('d F Y') }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted small">Status saat ini</span>
                        <span class="badge rounded-pill px-3 py-2 fw-medium" style="background:#eff6ff; color:#1d4ed8; font-size:0.75rem;">
                            <i class="bi bi-check-circle me-1"></i>Dipinjam
                        </span>
                    </div>
                </div>

                <div class="d-flex flex-column gap-2">
                    <form action="{{ route('user.kembalikanBuku', $trx->id) }}" method="POST" class="w-100">
                        @csrf
                        <button type="submit" class="btn btn-success w-100 py-3 fw-bold rounded-3 shadow-sm" style="background:#059669; border:none; font-size:0.95rem;">
                            <i class="bi bi-check-circle me-1"></i> Konfirmasi Pengembalian
                        </button>
                    </form>
                    <a href="{{ route('user.books') }}" class="btn btn-light w-100 py-3 fw-bold rounded-3 text-muted border border-2" style="font-size:0.95rem;">
                        Batal
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    body { font-family: 'Inter', 'Outfit', sans-serif; background: #f4f7fb; }
</style>

@endsection
