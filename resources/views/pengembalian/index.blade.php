@extends('layouts.admin')

@section('page_title', 'Pengembalian')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <p class="text-muted small mb-0">Riwayat buku yang sudah dikembalikan dan pengajuan yang ditolak.</p>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success border-0 shadow-sm mb-4" style="background-color: #ecfdf5; color: #059669; border-radius: 10px;">
    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
</div>
@endif

{{-- ========================= MENUNGGU PERSETUJUAN ========================= --}}
@if($menungguKembali->count() > 0)
<div class="d-flex align-items-center gap-2 mb-3 mt-2">
    <h6 class="fw-bold mb-0 text-danger">Menunggu Persetujuan Pengembalian</h6>
    <span class="badge bg-danger rounded-pill px-2" style="font-size: 0.75rem;">{{ $menungguKembali->count() }} antrean</span>
</div>

<div class="card border-0 shadow-sm overflow-hidden mb-5" style="border-radius: 15px;">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr style="background-color: #fef2f2;">
                    <th class="ps-4 py-3 fw-medium text-danger" style="font-size: 0.78rem;">NO</th>
                    <th class="py-3 fw-medium text-danger" style="font-size: 0.78rem;">ANGGOTA</th>
                    <th class="py-3 fw-medium text-danger" style="font-size: 0.78rem;">JUDUL BUKU</th>
                    <th class="py-3 fw-medium text-danger" style="font-size: 0.78rem;">TGL PINJAM</th>
                    <th class="py-3 fw-medium text-danger text-center" style="font-size: 0.78rem;">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @foreach($menungguKembali as $trx)
                <tr>
                    <td class="ps-4 text-muted">{{ $loop->iteration }}</td>
                    <td><span class="fw-semibold text-dark">{{ $trx->peminjaman->member->nama }}</span></td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div style="width: 32px; height: 32px; background: rgba(239,68,68,0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i class="bi bi-book-fill" style="color: #ef4444; font-size: 0.85rem;"></i>
                            </div>
                            <span class="fw-medium">{{ $trx->peminjaman->book->judul }}</span>
                        </div>
                    </td>
                    <td>
                        <div class="small"><i class="bi bi-calendar-event me-1"></i> {{ $trx->peminjaman->tanggal_pinjam }}</div>
                    </td>
                    <td class="text-center">
                        <form action="{{ route('pengembalian.setujui', $trx->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success rounded-pill px-3 fw-medium" onclick="return confirm('Setujui pengembalian buku ini?')">
                                <i class="bi bi-check-circle me-1"></i> Setujui
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

{{-- ========================= BUKU DIKEMBALIKAN ========================= --}}
<div class="d-flex align-items-center gap-2 mb-3">
    <h6 class="fw-bold mb-0">Buku Dikembalikan</h6>
    <span class="badge px-2" style="font-size: 0.75rem; background: #f0fdf4; color: #15803d;">{{ $dikembalikan->count() }} selesai</span>
</div>

<div class="card border-0 shadow-sm overflow-hidden mb-4" style="border-radius: 15px;">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr style="background-color: #f8fafc;">
                    <th class="ps-4 py-3 fw-medium text-muted" style="font-size: 0.78rem;">NO</th>
                    <th class="py-3 fw-medium text-muted" style="font-size: 0.78rem;">ANGGOTA</th>
                    <th class="py-3 fw-medium text-muted" style="font-size: 0.78rem;">JUDUL BUKU</th>
                    <th class="py-3 fw-medium text-muted" style="font-size: 0.78rem;">TGL PINJAM</th>
                    <th class="py-3 fw-medium text-muted" style="font-size: 0.78rem;">TGL KEMBALI</th>
                    <th class="py-3 fw-medium text-muted" style="font-size: 0.78rem;">STATUS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dikembalikan as $trx)
                <tr>
                    <td class="ps-4 text-muted">{{ $loop->iteration }}</td>
                    <td>
                        <span class="fw-semibold text-dark">{{ $trx->peminjaman->member->nama }}</span>
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div style="width: 32px; height: 32px; background: rgba(21,128,61,0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i class="bi bi-book-fill" style="color: #15803d; font-size: 0.85rem;"></i>
                            </div>
                            <span class="fw-medium">{{ $trx->peminjaman->book->judul }}</span>
                        </div>
                    </td>
                    <td>
                        <div class="small"><i class="bi bi-calendar-event me-1"></i> {{ $trx->peminjaman->tanggal_pinjam }}</div>
                    </td>
                    <td>
                        <div class="small"><i class="bi bi-calendar-check me-1 text-success"></i> {{ $trx->tanggal_kembali }}</div>
                    </td>
                    <td>
                        <span class="badge rounded-pill px-3 py-2" style="background-color: #f0fdf4; color: #15803d; font-weight: 500; font-size: 0.75rem;">
                            <i class="bi bi-check-lg me-1"></i> Dikembalikan
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">
                        <i class="bi bi-arrow-return-left fs-1 d-block mb-2 opacity-25"></i>
                        Belum ada buku yang dikembalikan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

