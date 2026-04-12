@extends('layouts.admin')

@section('title')
Edit Anggota
@endsection

@section('content')

<h2 class="mb-4">Edit Anggota</h2>

<div class="card shadow-sm">

<div class="card-body">

<form action="/members/update/{{ $member->id }}" method="POST">

@csrf

<div class="mb-3">
<label>Nama</label>
<input type="text" name="nama" value="{{ $member->nama }}" class="form-control">
</div>

<div class="mb-3">
<label>Email</label>
<input type="email" name="email" value="{{ $member->email }}" class="form-control">
</div>

<div class="mb-3">
<label>Role</label>

<select name="role" class="form-control">

<option value="user" {{ $member->role == 'user' ? 'selected' : '' }}>
User
</option>

<option value="admin" {{ $member->role == 'admin' ? 'selected' : '' }}>
Admin
</option>

</select>

</div>

<button class="btn btn-primary">
Update Anggota
</button>

<a href="/members" class="btn btn-secondary">
Kembali
</a>

</form>

</div>

</div>

@endsection