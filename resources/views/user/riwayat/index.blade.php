@extends('layouts.admin')

@section('title', 'Riwayat Peminjaman')

@section('content')
<div class="card bg-white p-4 shadow-sm rounded">
    <h3 class="mb-3">Riwayat Peminjaman</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Buku</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $trx)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $trx->book->judul }}</td>
                <td>{{ $trx->tanggal_pinjam }}</td>
                <td>{{ $trx->tanggal_kembali }}</td>
                <td>{{ $trx->status }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center text-muted">Belum ada riwayat peminjaman.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
