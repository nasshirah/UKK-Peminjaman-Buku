@extends('layouts.admin')

@section('title')
Tambah Buku
@endsection

@section('content')

<h2 class="mb-4">Tambah Buku</h2>

<div class="card shadow-sm">

<div class="card-body">

<form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">

@csrf

<div class="mb-3">
<label class="form-label">Judul Buku</label>
<input type="text" name="judul" class="form-control" placeholder="Masukkan judul buku" required>
</div>

<div class="mb-3">
<label class="form-label">Penulis</label>
<input type="text" name="penulis" class="form-control" placeholder="Masukkan penulis" required>
</div>

<div class="mb-3">
<label class="form-label">Penerbit</label>
<input type="text" name="penerbit" class="form-control" placeholder="Masukkan penerbit" required>
</div>

<div class="mb-3">
<label class="form-label">Tahun</label>
<input type="number" name="tahun" class="form-control" placeholder="Masukkan tahun terbit" required>
</div>

<div class="mb-3">
<label class="form-label">Stok</label>
<input type="number" name="stok" class="form-control" placeholder="Masukkan jumlah stok" required>
</div>

<div class="mb-3">
<label class="form-label">Gambar Buku</label>
<input type="file" name="gambar" class="form-control" accept="image/*">
<small class="text-muted">Format: JPG, PNG, JPEG. Maks 2MB. (Opsional)</small>
</div>

<button type="submit" class="btn btn-primary">
Simpan Buku
</button>

<a href="/books" class="btn btn-secondary">
Kembali
</a>

</form>

</div>

</div>

@endsection