@extends('layouts.user')

@section('title', 'Daftar Buku')

@section('content')

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 pb-2 border-bottom">
    <div>
        <h3 class="fw-bolder text-dark mb-1">Koleksi Buku</h3>
        <p class="text-muted mb-0">Jelajahi seluruh koleksi bahan bacaan yang ada di perpustakaan kami.</p>
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
                        <th class="border-0 fw-bold py-3 text-uppercase">Penerbit</th>
                        <th class="border-0 fw-bold py-3 text-uppercase">Tahun</th>
                        <th class="border-0 fw-bold py-3 text-center text-uppercase">Stok</th>
                        <th class="border-0 fw-bold py-3 px-4 text-end text-uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @forelse($books as $book)
                        <tr class="table-row-hover">
                            <td class="text-muted fw-medium px-4">{{ $loop->iteration }}</td>
                            <td class="fw-semibold py-4 text-dark">
                                <div class="d-flex align-items-center">
                                    <div class="bg-light rounded p-2 me-3 d-flex align-items-center justify-content-center text-primary flex-shrink-0" style="width:45px; height:45px;">
                                        <i class="bi bi-book fs-5"></i>
                                    </div>
                                    <div>
                                        <div class="mb-1 text-truncate" style="max-width: 250px;" title="{{ $book->judul }}">{{ $book->judul }}</div>
                                        <div class="text-secondary small fw-medium"><i class="bi bi-person me-1"></i> {{ $book->penulis }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-secondary fw-medium">{{ $book->penerbit }}</td>
                            <td class="text-secondary fw-medium">{{ $book->tahun }}</td>
                            <td class="text-center fw-bold text-dark fs-5">{{ $book->stok }}</td>
                            <td class="text-end px-4">
                                @if($book->stok > 0)
                                    <span class="modern-badge badge-success">Tersedia</span>
                                @else
                                    <span class="modern-badge badge-danger">Habis</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted fw-medium">
                                <div class="empty-state py-4">
                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px;">
                                        <i class="bi bi-inbox text-muted fs-1"></i>
                                    </div>
                                    Belum ada buku yang ditambahkan ke perpustakaan.
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
    
    /* Modern Table */
    .premium-table-card { transition: box-shadow 0.3s ease; }
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
    .badge-success { background: #ecfdf5; color: #10b981; }
    .badge-danger  { background: #fef2f2; color: #ef4444; }
</style>

@endsection