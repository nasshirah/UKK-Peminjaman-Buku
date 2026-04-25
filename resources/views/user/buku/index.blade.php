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
                        <th class="border-0 fw-bold py-3 px-4 text-center text-uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @forelse($books as $book)
                        <tr class="table-row-hover">
                            <td class="text-muted fw-medium px-4">{{ $loop->iteration }}</td>
                            <td class="fw-semibold py-4 text-dark">
                                <div class="d-flex align-items-center">
                                    @if($book->gambar)
                                    <img src="{{ asset('storage/' . $book->gambar) }}" alt="{{ $book->judul }}" 
                                         class="me-3 flex-shrink-0" style="width:45px; height:60px; object-fit:cover; border-radius:8px;">
                                    @else
                                    <div class="bg-light rounded p-2 me-3 d-flex align-items-center justify-content-center text-primary flex-shrink-0" style="width:45px; height:60px;">
                                        <i class="bi bi-book fs-5"></i>
                                    </div>
                                    @endif
                                    <div>
                                        <div class="mb-1 text-truncate" style="max-width: 250px;" title="{{ $book->judul }}">{{ $book->judul }}</div>
                                        <div class="text-secondary small fw-medium"><i class="bi bi-person me-1"></i> {{ $book->penulis }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-secondary fw-medium">{{ $book->penerbit }}</td>
                            <td class="text-secondary fw-medium">{{ $book->tahun }}</td>
                            <td class="text-center fw-bold text-dark fs-5">{{ $book->stok }}</td>
                            <td class="text-center px-4">
                                @if($book->stok <= 0)
                                    {{-- Buku tidak tersedia --}}
                                    <span class="modern-badge badge-danger">Tidak Tersedia</span>
                                @elseif($pinjamAktif ?? false)
                                    {{-- User masih ada pinjaman aktif --}}
                                    <span class="modern-badge badge-warning" title="Anda masih memiliki peminjaman aktif.">Tidak bisa pinjam lagi</span>
                                @else
                                    {{-- Buku tersedia & user bisa pinjam --}}
                                    <button type="button" class="btn btn-primary btn-sm rounded-pill px-4 fw-bold shadow-sm btn-hover-scale"
                                        data-bs-toggle="modal" data-bs-target="#modalPinjam{{ $book->id }}">
                                        <i class="bi bi-bookmark-plus-fill me-1"></i> Pinjam
                                    </button>

                                    {{-- Modal Pilih Tanggal Kembali --}}
                                    <div class="modal fade" id="modalPinjam{{ $book->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-sm">
                                            <div class="modal-content border-0 shadow" style="border-radius: 16px;">
                                                <div class="modal-header border-0 pb-0 px-4 pt-4">
                                                    <h6 class="modal-title fw-bold text-dark">Pinjam Buku</h6>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form action="{{ route('user.pinjam', $book->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-body px-4 py-3">
                                                        <div class="mb-3">
                                                            <div class="d-flex align-items-center gap-2 mb-3 p-3 rounded-3" style="background:#f8fafc;">
                                                                <div style="width:36px; height:36px; border-radius:10px; background:rgba(29,78,216,0.08); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                                                    <i class="bi bi-book-fill" style="color:#1d4ed8;"></i>
                                                                </div>
                                                                <div>
                                                                    <div class="fw-semibold text-dark" style="font-size:0.88rem;">{{ $book->judul }}</div>
                                                                    <div class="text-muted" style="font-size:0.75rem;">{{ $book->penulis }}</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <label class="form-label fw-semibold text-dark" style="font-size:0.85rem;">
                                                            <i class="bi bi-calendar-event me-1"></i> Tanggal Pengembalian
                                                        </label>
                                                        <input type="date" name="tanggal_kembali" class="form-control"
                                                            min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                                            max="{{ date('Y-m-d', strtotime('+30 days')) }}"
                                                            value="{{ date('Y-m-d', strtotime('+7 days')) }}"
                                                            required
                                                            style="border-radius:10px; padding:10px 14px; border:1px solid #e2e8f0;">
                                                        <div class="text-muted mt-1" style="font-size:0.72rem;">
                                                            Maksimal 30 hari dari hari ini.
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer border-0 px-4 pb-4 pt-0">
                                                        <button type="button" class="btn btn-light btn-sm rounded-pill px-3 fw-medium" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary btn-sm rounded-pill px-4 fw-bold shadow-sm">
                                                            <i class="bi bi-bookmark-plus-fill me-1"></i> Pinjam Sekarang
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
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
        display: inline-block; padding: 0.5rem 1rem; border-radius: 30px; font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase;
    }
    .badge-success { background: #ecfdf5; color: #10b981; }
    .badge-danger  { background: #fef2f2; color: #ef4444; }
    .badge-warning { background: #fffbeb; color: #b45309; }
    
    .btn-hover-scale { transition: all 0.25s ease; }
    .btn-hover-scale:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(59, 130, 246, 0.25) !important; }
</style>

@endsection