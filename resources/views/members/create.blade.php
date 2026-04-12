@extends('layouts.admin')

@section('title')
Tambah Anggota
@endsection

@section('content')

<h2 class="mb-4">Tambah Anggota</h2>

<div class="card shadow-sm">

<div class="card-body">

<form action="/members/store" method="POST">

@csrf

<div class="mb-3">
<label class="form-label">Nama</label>
<input 
type="text" 
name="nama" 
class="form-control"
placeholder="Masukkan nama anggota"
required
>
</div>


<div class="mb-3">
<label class="form-label">Email</label>
<input 
type="email" 
name="email" 
class="form-control"
placeholder="Masukkan email"
required
>
</div>


<div class="mb-3">
<label class="form-label">Password</label>
<input 
type="password" 
name="password" 
class="form-control"
placeholder="Masukkan password"
required
>
</div>


<div class="mb-3">

<label class="form-label">Role Pengguna</label>

<div class="input-group">

<span class="input-group-text">
<i class="bi bi-person-badge"></i>
</span>

<select name="role" class="form-select" required>

<option value="">-- Pilih Role --</option>
<option value="user">User</option>
<option value="admin">Admin</option>

</select>

</div>

</div>


<button class="btn btn-primary">
Simpan Anggota
</button>

<a href="/members" class="btn btn-secondary">
Kembali
</a>

</form>

</div>

</div>

@endsection