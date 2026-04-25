@extends('layouts.admin')

@section('title')
Edit Buku
@endsection

@section('content')

<h2 class="mb-4">Edit Buku</h2>

<div class="card shadow-sm">

<div class="card-body">

<form action="/books/update/{{ $book->id }}" method="POST" enctype="multipart/form-data">

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

<div class="mb-3">
<label>Gambar Buku</label>
@if($book->gambar)
<div class="mb-2">
    <img src="{{ asset('storage/' . $book->gambar) }}" alt="Gambar Buku" class="img-thumbnail" style="max-height: 150px;">
    <p class="text-muted small mt-1">Gambar saat ini. Upload gambar baru untuk mengganti.</p>
</div>
@endif
<input type="file" name="gambar" class="form-control" accept="image/*">
<small class="text-muted">Format: JPG, PNG, JPEG. Maks 2MB. (Kosongkan jika tidak ingin mengubah gambar)</small>
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