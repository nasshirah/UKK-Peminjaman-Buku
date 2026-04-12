@extends('layouts.admin')

@section('title')
Edit Buku
@endsection

@section('content')

<h2 class="mb-4">Edit Buku</h2>

<div class="card shadow-sm">

<div class="card-body">

<form action="/books/update/{{ $book->id }}" method="POST">

@csrf

<div class="mb-3">
<label>Judul Buku</label>
<input type="text" name="judul" value="{{ $book->judul }}" class="form-control">
</div>

<div class="mb-3">
<label>Penulis</label>
<input type="text" name="penulis" value="{{ $book->penulis }}" class="form-control">
</div>

<div class="mb-3">
<label>Penerbit</label>
<input type="text" name="penerbit" value="{{ $book->penerbit }}" class="form-control">
</div>

<div class="mb-3">
<label>Tahun</label>
<input type="number" name="tahun" value="{{ $book->tahun }}" class="form-control">
</div>

<div class="mb-3">
<label>Stok</label>
<input type="number" name="stok" value="{{ $book->stok }}" class="form-control">
</div>

<button class="btn btn-primary">
Update Buku
</button>

<a href="/books" class="btn btn-secondary">
Kembali
</a>

</form>

</div>

</div>

@endsection