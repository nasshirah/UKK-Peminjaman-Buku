@extends('layouts.admin')

@section('page_title', 'Daftar Koleksi Buku')

@section('content')

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

<div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 15px;">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th class="ps-4">No</th>
                    <th>Judul Buku</th>
                    <th>Penulis</th>
                    <th>Penerbit</th>
                    <th class="text-center">Tahun</th>
                    <th class="text-center">Stok</th>
                    <th class="pe-4 text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($books as $book)
                <tr>
                    <td class="ps-4 text-muted">{{ $loop->iteration }}</td>
                    <td class="fw-bold text-dark">{{ $book->judul }}</td>
                    <td>{{ $book->penulis }}</td>
                    <td>{{ $book->penerbit }}</td>
                    <td class="text-center"><span class="badge bg-light text-dark fw-normal">{{ $book->tahun }}</span></td>
                    <td class="text-center fw-bold">{{ $book->stok }}</td>
                    <td class="pe-4">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('books.edit', $book->id) }}" 
                               class="btn btn-sm d-flex align-items-center justify-content-center" 
                               style="background-color: #fffbeb; color: #d97706; width: 35px; height: 35px; border-radius: 8px;" 
                               title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </a>

                            <a href="{{ route('books.delete', $book->id) }}" 
                               class="btn btn-sm d-flex align-items-center justify-content-center" 
                               style="background-color: #fef2f2; color: #dc2626; width: 35px; height: 35px; border-radius: 8px;"
                               onclick="return confirm('Yakin ingin menghapus buku ini?')" 
                               title="Hapus">
                                <i class="bi bi-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">Belum ada data buku.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection