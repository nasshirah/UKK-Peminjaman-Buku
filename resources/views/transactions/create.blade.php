@extends('layouts.admin')

@section('title')
Pinjam Buku
@endsection

@section('content')

<h2 class="mb-4">Pinjam Buku</h2>

<div class="card">

<div class="card-body">

<form action="/transactions/store" method="POST">

@csrf

<div class="mb-3">

<label>Anggota</label>

<select name="member_id" class="form-control">

@foreach($members as $member)

<option value="{{ $member->id }}">
{{ $member->nama }}
</option>

@endforeach

</select>

</div>


<div class="mb-3">

<label>Buku</label>

<select name="book_id" class="form-control">

@foreach($books as $book)

<option value="{{ $book->id }}">
{{ $book->judul }}
</option>

@endforeach

</select>

</div>

<button class="btn btn-primary">
Pinjam Buku
</button>

<a href="/transactions" class="btn btn-secondary">
Kembali
</a>

</form>

</div>

</div>

@endsection