@extends('layouts.admin')

@section('title')
Buku Dipinjam
@endsection

@section('content')

<h2>Buku Yang Dipinjam</h2>

<table class="table table-bordered">

<thead>

<tr>
<th>No</th>
<th>Buku</th>
<th>Tanggal Pinjam</th>
<th>Status</th>
</tr>

</thead>

<tbody>

@foreach($transactions as $trx)

<tr>

<td>{{ $loop->iteration }}</td>
<td>{{ $trx->book->judul }}</td>
<td>{{ $trx->tanggal_pinjam }}</td>
<td>{{ $trx->status }}</td>

</tr>

@endforeach

</tbody>

</table>

@endsection