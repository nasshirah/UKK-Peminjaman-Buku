@extends('layouts.user')

@section('title', 'Daftar Buku')

@section('content')

<h3 class="mb-3">📚 Daftar Buku</h3>
<p class="text-muted">Berikut adalah semua koleksi buku yang tersedia</p>

<div class="card shadow-sm border-0">
<div class="card-body">

<table class="table table-hover align-middle">

<thead class="table-light">
<tr>
<th width="50">No</th>
<th>Judul</th>
<th>Penulis</th>
<th>Penerbit</th>
<th width="100">Tahun</th>
<th width="100">Stok</th>
<th width="120">Status</th>
</tr>
</thead>

<tbody>

@if($books->count() > 0)

@foreach($books as $book)
<tr>

<td>{{ $loop->iteration }}</td>
<td><strong>{{ $book->judul }}</strong></td>
<td>{{ $book->penulis }}</td>
<td>{{ $book->penerbit }}</td>
<td>{{ $book->tahun }}</td>

<td>{{ $book->stok }}</td>

<td>
    @if($book->stok > 0)
        <span class="badge bg-success">Tersedia</span>
    @else
        <span class="badge bg-danger">Habis</span>
    @endif
</td>

</tr>
@endforeach

@else

<tr>
<td colspan="7" class="text-center text-muted">
    Belum ada buku 📭
</td>
</tr>

@endif

</tbody>

</table>

</div>
</div>

@endsection