@extends('layouts.user')

@section('title', 'Daftar Buku')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap');
    body { font-family: 'Outfit', sans-serif; background-color: #f4f7fb; }
    
    .book-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        height: 100%;
        display: flex;
        flex-direction: column;
        border: 1px solid #f1f5f9;
        overflow: hidden;
    }
    .book-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        border-color: #e2e8f0;
    }
    .book-card-img-wrapper {
        position: relative;
        width: 100%;
        height: 280px;
        background: linear-gradient(135deg, #eff6ff 0%, #f0fdf4 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        overflow: hidden;
    }
    .book-card-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        filter: drop-shadow(0 10px 15px rgba(0,0,0,0.15));
        transition: transform 0.5s ease;
    }
    .book-card:hover .book-card-img-wrapper img {
        transform: scale(1.08) rotate(-1deg);
    }
    .book-card-img-wrapper .placeholder-icon {
        font-size: 3.5rem;
        color: #93c5fd;
    }
    .book-card-body {
        padding: 20px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .book-card-title {
        font-size: 1.15rem;
        font-weight: 700;
        color: #0f172a;
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
        margin-bottom: 16px;
        font-weight: 500;
    }
    .book-card-meta {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
        margin-top: auto;
    }
    .book-meta-badge {
        font-size: 0.75rem;
        padding: 4px 10px;
        border-radius: 20px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
    }
    .badge-publisher { background-color: #f1f5f9; color: #475569; }
    .badge-year { background-color: #eff6ff; color: #2563eb; }
    .badge-stock { background-color: #fefce8; color: #a16207; }
    .badge-stock-zero { background-color: #fef2f2; color: #dc2626; }
    
    .book-card-footer {
        padding: 0 20px 20px;
        display: flex;
    }
    
    /* Modern Badges & Buttons */
    .modern-badge {
        display: flex; align-items: center; justify-content: center; width: 100%;
        padding: 0.6rem 1rem; border-radius: 30px; font-size: 0.8rem; font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase;
    }
    .badge-danger  { background: #fef2f2; color: #ef4444; border: 1px solid #fee2e2; }
    .badge-warning { background: #fffbeb; color: #d97706; border: 1px solid #fef3c7; }
    
    .btn-hover-scale { transition: all 0.25s ease; width: 100%; }
    .btn-hover-scale:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(29, 78, 216, 0.25) !important; }
    
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }
</style>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 pb-2 border-bottom">
    <div>
        <h3 class="fw-bolder text-dark mb-1">Koleksi Buku</h3>
        <p class="text-muted mb-0">Jelajahi seluruh koleksi bahan bacaan yang ada di perpustakaan kami.</p>
    </div>
</div>

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
                <div class="book-card-title" title="{{ $book->judul }}">{{ $book->judul }}</div>
                <div class="book-card-author"><i class="bi bi-person me-1"></i> {{ $book->penulis }}</div>
                <div class="book-card-meta">
                    <span class="book-meta-badge badge-publisher"><i class="bi bi-building me-1"></i>{{ $book->penerbit }}</span>
                    <span class="book-meta-badge badge-year"><i class="bi bi-calendar3 me-1"></i>{{ $book->tahun }}</span>
                    <span class="book-meta-badge {{ $book->stok > 0 ? 'badge-stock' : 'badge-stock-zero' }}">
                        <i class="bi bi-box-seam me-1"></i>Stok: {{ $book->stok }}
                    </span>
                </div>
            </div>
            <div class="book-card-footer">
                @if($book->stok <= 0)
                    <span class="modern-badge badge-danger">Tidak Tersedia</span>
                @elseif($pinjamAktif ?? false)
                    <span class="modern-badge badge-warning" title="Anda masih memiliki peminjaman aktif.">Tidak Bisa Pinjam</span>
                @else
                    <button type="button" class="btn btn-primary btn-sm rounded-pill fw-bold shadow-sm btn-hover-scale"
                        data-bs-toggle="modal" data-bs-target="#modalPinjam{{ $book->id }}">
                        <i class="bi bi-bookmark-plus-fill me-1"></i> Pinjam Buku
                    </button>
                @endif
            </div>
        </div>

        @if($book->stok > 0 && !($pinjamAktif ?? false))
        {{-- Modal Pilih Tanggal Kembali --}}
        <div class="modal fade" id="modalPinjam{{ $book->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content border-0 shadow" style="border-radius: 20px;">
                    <div class="modal-header border-0 pb-0 px-4 pt-4">
                        <h6 class="modal-title fw-bold text-dark fs-5">Pinjam Buku</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('user.pinjam', $book->id) }}" method="POST">
                        @csrf
                        <div class="modal-body px-4 py-4">
                            <div class="d-flex align-items-center gap-3 mb-4 p-3 rounded-4" style="background:#f8fafc; border: 1px solid #f1f5f9;">
                                @if($book->gambar)
                                    <img src="{{ asset('storage/' . $book->gambar) }}" alt="{{ $book->judul }}" style="width: 40px; height: 55px; object-fit: cover; border-radius: 6px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                @else
                                    <div style="width:40px; height:55px; border-radius:6px; background:rgba(29,78,216,0.08); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                        <i class="bi bi-book-fill" style="color:#1d4ed8;"></i>
                                    </div>
                                @endif
                                <div>
                                    <div class="fw-bold text-dark" style="font-size:0.95rem; line-height: 1.2;">{{ $book->judul }}</div>
                                    <div class="text-muted mt-1" style="font-size:0.8rem;">{{ $book->penulis }}</div>
                                </div>
                            </div>
                            <label class="form-label fw-semibold text-dark mb-2" style="font-size:0.9rem;">
                                <i class="bi bi-calendar-event me-1 text-primary"></i> Tanggal Pengembalian
                            </label>
                            <input type="date" name="tanggal_kembali" class="form-control form-control-lg"
                                min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                max="{{ date('Y-m-d', strtotime('+30 days')) }}"
                                value="{{ date('Y-m-d', strtotime('+7 days')) }}"
                                required
                                style="border-radius:12px; font-size: 0.95rem; border:2px solid #e2e8f0; box-shadow: none;">
                            <div class="text-muted mt-2" style="font-size:0.8rem;">
                                <i class="bi bi-info-circle me-1"></i> Maksimal 30 hari peminjaman.
                            </div>
                        </div>
                        <div class="modal-footer border-0 px-4 pb-4 pt-0 gap-2">
                            <button type="button" class="btn btn-light rounded-pill px-4 fw-medium flex-fill" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm flex-fill">
                                Pinjam Sekarang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
    </div>
    @endforeach
</div>
@else
<div class="empty-state">
    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto mb-4" style="width: 100px; height: 100px;">
        <i class="bi bi-bookshelf text-muted fs-1"></i>
    </div>
    <h4 class="fw-bold text-dark">Koleksi Kosong</h4>
    <p class="text-muted">Belum ada buku yang ditambahkan ke perpustakaan.</p>
</div>
@endif

@endsection