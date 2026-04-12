<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Peminjaman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { 
            background: #f8f9fa; 
            font-family: 'Inter', sans-serif;
            padding: 50px 20px;
        }
    </style>
</head>
<body>

<div class="container">
    {{-- Tombol kembali --}}
    <div class="row justify-content-center mb-4">
        <div class="col-md-7">
            <a href="{{ route('user.books') }}" class="text-decoration-none d-inline-flex align-items-center gap-1 text-muted" style="font-size: 0.9rem;">
                <i class="bi bi-arrow-left"></i> Kembali ke Daftar Buku
            </a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-7">

            <div class="card border-0 shadow-sm" style="border-radius: 16px;">

                {{-- Header --}}
                <div class="card-header border-0 px-4 pt-4 pb-0 bg-transparent">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(25,135,84,0.1); display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-send text-success fs-4"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0">Ajukan Peminjaman</h5>
                            <p class="text-muted small mb-0">Pengajuan akan diproses oleh admin perpustakaan</p>
                        </div>
                    </div>
                </div>

                <div class="card-body px-4 pb-4">

                    {{-- Info Buku --}}
                    <div class="p-3 mb-4" style="background: #f8f9fa; border-radius: 12px;">
                        <p class="text-muted small mb-1 fw-medium" style="font-size: 0.72rem; letter-spacing: 0.5px;">BUKU YANG AKAN DIPINJAM</p>
                        <h6 class="fw-bold text-dark mb-1">{{ $book->judul }}</h6>
                        <p class="text-muted small mb-0">{{ $book->penulis }} &bull; {{ $book->penerbit }} &bull; {{ $book->tahun }}</p>
                        <div class="mt-2">
                            @if($book->stok > 0)
                                <span class="badge rounded-pill px-3 py-1" style="background: rgba(25,135,84,0.1); color: #198754; font-size: 0.75rem;">
                                    Stok: {{ $book->stok }}
                                </span>
                            @else
                                <span class="badge rounded-pill px-3 py-1" style="background: rgba(220,53,69,0.08); color: #dc3545; font-size: 0.75rem;">
                                    Stok Habis
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Jika sudah punya pengajuan aktif --}}
                    @if($sudahAjukan)
                        <div class="p-3 mb-3" style="background: #fff7ed; border-radius: 10px; border-left: 3px solid #f97316;">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-exclamation-triangle-fill" style="color: #f97316;"></i>
                                <p class="mb-0 fw-medium" style="color: #c2410c; font-size: 0.88rem;">
                                    Kamu sudah memiliki pengajuan aktif untuk buku ini.
                                </p>
                            </div>
                        </div>

                        <a href="{{ route('user.books') }}" class="btn fw-medium px-4"
                            style="background: #6c757d; color: white; border-radius: 10px; border: none;">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>

                    {{-- Jika stok habis --}}
                    @elseif($book->stok <= 0)
                        <div class="p-3 mb-3" style="background: #fef2f2; border-radius: 10px; border-left: 3px solid #dc2626;">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-x-circle-fill text-danger"></i>
                                <p class="mb-0 fw-medium text-danger" style="font-size: 0.88rem;">
                                    Maaf, stok buku ini sudah habis.
                                </p>
                            </div>
                        </div>

                        <a href="{{ route('user.books') }}" class="btn fw-medium px-4"
                            style="background: #6c757d; color: white; border-radius: 10px; border: none;">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>

                    {{-- Form pengajuan --}}
                    @else
                        <form action="{{ route('user.pinjamBuku') }}" method="POST">
                            @csrf

                            <input type="hidden" name="book_id" value="{{ $book->id }}">

                            {{-- Tanggal Pinjam --}}
                            <div class="mb-3">
                                <label for="tanggal_pinjam" class="form-label fw-medium text-dark" style="font-size: 0.88rem;">
                                    <i class="bi bi-calendar-event me-1 text-success"></i> Tanggal Pinjam
                                </label>
                                <input type="date" name="tanggal_pinjam" id="tanggal_pinjam"
                                    class="form-control @error('tanggal_pinjam') is-invalid @enderror"
                                    style="border-radius: 10px; box-shadow: none;"
                                    value="{{ old('tanggal_pinjam', date('Y-m-d')) }}"
                                    required>
                                @error('tanggal_pinjam')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tanggal Kembali --}}
                            <div class="mb-4">
                                <label for="tanggal_kembali" class="form-label fw-medium text-dark" style="font-size: 0.88rem;">
                                    <i class="bi bi-calendar-check me-1 text-success"></i> Rencana Tanggal Kembali
                                </label>
                                <input type="date" name="tanggal_kembali" id="tanggal_kembali"
                                    class="form-control @error('tanggal_kembali') is-invalid @enderror"
                                    style="border-radius: 10px; box-shadow: none;"
                                    value="{{ old('tanggal_kembali', date('Y-m-d', strtotime('+7 days'))) }}"
                                    min="{{ date('Y-m-d') }}"
                                    max="{{ date('Y-m-d', strtotime('+7 days')) }}"
                                    required>
                                <div class="form-text text-muted" style="font-size: 0.78rem;">Maksimal peminjaman 7 hari</div>
                                @error('tanggal_kembali')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Info alur (PHP/Blade, tanpa JavaScript) --}}
                            <div class="mb-4">
                                <p class="text-muted fw-medium small mb-2">Alur peminjaman:</p>
                                <div class="d-flex flex-column gap-2">
                                    <div class="d-flex align-items-center gap-2 px-3 py-2"
                                        style="background: #f0fdf4; border-radius: 8px;">
                                        <span class="badge rounded-circle bg-success d-flex align-items-center justify-content-center" style="width: 22px; height: 22px; font-size: 0.7rem;">1</span>
                                        <span class="text-success fw-medium" style="font-size: 0.78rem;">Kamu mengajukan peminjaman</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2 px-3 py-2"
                                        style="background: #fff7ed; border-radius: 8px;">
                                        <span class="badge rounded-circle d-flex align-items-center justify-content-center" style="background: #f97316; width: 22px; height: 22px; font-size: 0.7rem;">2</span>
                                        <span class="fw-medium" style="color: #c2410c; font-size: 0.78rem;">Admin meninjau & menyetujui</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2 px-3 py-2"
                                        style="background: #eff6ff; border-radius: 8px;">
                                        <span class="badge rounded-circle bg-primary d-flex align-items-center justify-content-center" style="width: 22px; height: 22px; font-size: 0.7rem;">3</span>
                                        <span class="text-primary fw-medium" style="font-size: 0.78rem;">Buku siap diambil</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Tombol --}}
                            <div class="d-flex gap-2">
                                <a href="{{ route('user.books') }}" class="btn btn-light fw-medium px-4"
                                    style="border-radius: 10px;">
                                    Batal
                                </a>
                                <button type="submit" class="btn fw-medium px-4"
                                    style="background: #198754; color: white; border-radius: 10px; border: none;">
                                    <i class="bi bi-send me-1"></i> Kirim Pengajuan
                                </button>
                            </div>
                        </form>
                    @endif

                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>
