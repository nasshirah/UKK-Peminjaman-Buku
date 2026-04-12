@extends('layouts.admin')

@section('page_title', 'Manajemen Anggota')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <p class="text-muted small mb-0">Kelola data petugas dan anggota perpustakaan.</p>
    </div>
    <a href="/members/create" class="btn fw-semibold px-4" 
       style="background-color: #10b981; color: white; border-radius: 10px; border: none;">
        + Tambah Anggota
    </a>
</div>

@if(session('success'))
<div class="alert alert-success border-0 shadow-sm mb-4" style="background-color: #ecfdf5; color: #059669;">
    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
</div>
@endif

<div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 15px;">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr style="background-color: #f8fafc;">
                    <th class="ps-4 py-3" width="60">NO</th>
                    <th class="py-3">NAMA LENGKAP</th>
                    <th class="py-3">ALAMAT EMAIL</th>
                    <th class="py-3">ROLE</th>
                    <th class="pe-4 py-3 text-end" width="150">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($members as $member)
                <tr>
                    <td class="ps-4 text-muted">{{ $loop->iteration }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($member->nama) }}&background=f0fdf4&color=10b981" 
                                 class="rounded-circle me-3" width="35" alt="avatar">
                            <span class="fw-bold text-dark">{{ $member->nama }}</span>
                        </div>
                    </td>
                    <td>{{ $member->email }}</td>
                    <td>
                        @if($member->role == 'admin')
                            <span class="badge rounded-pill px-3 py-2" style="background-color: #ecfdf5; color: #10b981; font-weight: 500;">
                                Admin
                            </span>
                        @else
                            <span class="badge rounded-pill px-3 py-2" style="background-color: #eff6ff; color: #3b82f6; font-weight: 500;">
                                Anggota
                            </span>
                        @endif
                    </td>
                    <td class="pe-4">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="/members/edit/{{ $member->id }}" 
                               class="btn btn-sm d-flex align-items-center justify-content-center" 
                               style="background-color: #fffbeb; color: #d97706; width: 35px; height: 35px; border-radius: 8px;" 
                               title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </a>

                            <a href="/members/delete/{{ $member->id }}" 
                               class="btn btn-sm d-flex align-items-center justify-content-center" 
                               style="background-color: #fef2f2; color: #dc2626; width: 35px; height: 35px; border-radius: 8px;"
                               onclick="return confirm('Yakin ingin menghapus anggota?')" 
                               title="Hapus">
                                <i class="bi bi-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5 text-muted">
                        <i class="bi bi-people fs-1 d-block mb-2 opacity-25"></i>
                        Belum ada data anggota.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection