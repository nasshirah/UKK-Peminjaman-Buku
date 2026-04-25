@extends('layouts.admin')

@section('page_title', 'Daftar Koleksi Buku')

@section('content')

<style>
    .book-card {
        border: none;
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: #fff;
        box-shadow: 0 1px 3px rgba(0,0,0,0.06);
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .book-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 32px rgba(0,0,0,0.12);
    }
    .book-card-img-wrapper {
        position: relative;
        width: 100%;
        height: 280px;
        background: linear-gradient(135deg, #e0e7ff 0%, #f0fdf4 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        padding: 15px;
    }
    .book-card-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        transition: transform 0.4s ease;
        filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1));
    }
    .book-card:hover .book-card-img-wrapper img {
        transform: scale(1.05);
    }
    .book-card-img-wrapper .placeholder-icon {
        font-size: 3rem;
        color: #a5b4fc;
    }
    .book-card-body {
        padding: 16px 18px 12px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .book-card-title {
        font-size: 1rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 6px;
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .book-card-author {
        font-size: 0.85rem;
        color: #64748b;
        margin-bottom: 10px;
    }
    .book-card-meta {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        margin-top: auto;
        margin-bottom: 0;
    }
    .book-meta-badge {
        font-size: 0.75rem;
        padding: 4px 10px;
        border-radius: 20px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .badge-publisher {
        background-color: #f0fdf4;
        color: #15803d;
    }
    .badge-year {
        background-color: #eff6ff;
        color: #1d4ed8;
    }
    .badge-stock {
        background-color: #fefce8;
        color: #a16207;
    }
    .badge-stock-zero {
        background-color: #fef2f2;
        color: #dc2626;
    }
    .book-card-footer {
        padding: 0 18px 16px;
        display: flex;
        gap: 8px;
    }
    .book-btn {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 8px 0;
        border-radius: 10px;
        font-size: 0.82rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
        border: none;
    }
    .book-btn-edit {
        background-color: #fffbeb;
        color: #d97706;
    }
    .book-btn-edit:hover {
        background-color: #fef3c7;
        color: #b45309;
    }
    .book-btn-delete {
        background-color: #fef2f2;
        color: #dc2626;
    }
    .book-btn-delete:hover {
        background-color: #fee2e2;
        color: #b91c1c;
    }
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.06);
    }
    .empty-state i {
        font-size: 3.5rem;
        color: #cbd5e1;
        margin-bottom: 16px;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <p class="text-muted small mb-0">Kelola dan lihat semua data buku yang tersedia.</p>
    </div>
    <a href="{{ route('books.create') }}" class="btn fw-semibold px-4" 
       style="background-color: #10b981; color: white; border-radius: 10px; border: none;">
        + Tambah Buku
    </a>
</div>

@if(session('success'))
<div class="alert alert-success border-0 shadow-sm mb-4" style="background-color: #ecfdf5; color: #059669;">
    {{ session('success') }}
</div>
@endif

@if($books->count() > 0)
<div class="row g-4">
    @foreach($books as $book)
    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
        <div class="book-card">
            <div class="book-card-img-wrapper">
                @if($book->gambar)
                    <img src="{{ asset('storage/' . $book->gambar) }}" alt="{{ $book->judul }}">
                @else
                    <i class="bi bi-book placeholder-icon"></i>
                @endif
            </div>
            <div class="book-card-body">
                <div class="book-card-title">{{ $book->judul }}</div>
                <div class="book-card-author">
                    <i class="bi bi-person-fill me-1"></i>{{ $book->penulis }}
                </div>
                <div class="book-card-meta">
                    <span class="book-meta-badge badge-publisher">
                        <i class="bi bi-building"></i> {{ $book->penerbit }}
                    </span>
                    <span class="book-meta-badge badge-year">
                        <i class="bi bi-calendar3"></i> {{ $book->tahun }}
                    </span>
                    <span class="book-meta-badge {{ $book->stok > 0 ? 'badge-stock' : 'badge-stock-zero' }}">
                        <i class="bi bi-box-seam"></i> Stok: {{ $book->stok }}
                    </span>
                </div>
            </div>
            <div class="book-card-footer">
                <a href="{{ route('books.edit', $book->id) }}" class="book-btn book-btn-edit" title="Edit">
                    <i class="bi bi-pencil-square"></i> Edit
                </a>
                <a href="{{ route('books.delete', $book->id) }}" class="book-btn book-btn-delete" 
                   onclick="return confirm('Yakin ingin menghapus buku ini?')" title="Hapus">
                    <i class="bi bi-trash"></i> Hapus
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="empty-state">
    <i class="bi bi-journal-bookmark d-block"></i>
    <h5 class="text-muted fw-semibold">Belum ada data buku</h5>
    <p class="text-muted small">Klik tombol "+ Tambah Buku" untuk menambahkan buku baru.</p>
</div>
@endif

@endsection