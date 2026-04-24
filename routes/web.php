<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;


/* AUTH */

Route::get('/', [AuthController::class,'login'])->name('login');
Route::post('/login', [AuthController::class,'loginProcess'])->name('login.process');
Route::get('/logout', [AuthController::class,'logout'])->name('logout');


/* DASHBOARD */

Route::get('/dashboard', [AuthController::class,'dashboard'])->name('dashboard');


/* BOOK CRUD */

Route::get('/books', [BookController::class,'index'])->name('books.index');
Route::get('/books/create', [BookController::class,'create'])->name('books.create');
Route::post('/books/store', [BookController::class,'store'])->name('books.store');
Route::get('/books/edit/{id}', [BookController::class,'edit'])->name('books.edit');
Route::post('/books/update/{id}', [BookController::class,'update'])->name('books.update');
Route::get('/books/delete/{id}', [BookController::class,'delete'])->name('books.delete');


/* MEMBERS */

Route::prefix('members')->group(function(){

    Route::get('/', [MemberController::class,'index'])->name('members.index');
    Route::get('/create', [MemberController::class,'create'])->name('members.create');
    Route::post('/store', [MemberController::class,'store'])->name('members.store');
    Route::get('/edit/{id}', [MemberController::class,'edit'])->name('members.edit');
    Route::post('/update/{id}', [MemberController::class,'update'])->name('members.update');
    Route::get('/delete/{id}', [MemberController::class,'delete'])->name('members.delete');

});


/* PEMINJAMAN */
use App\Http\Controllers\PeminjamanController;
Route::prefix('peminjaman')->group(function(){
    Route::get('/request', [PeminjamanController::class,'peminjaman'])->name('peminjaman.request');
    Route::post('/setujui/{id}', [PeminjamanController::class,'setujui'])->name('peminjaman.setujui');
    Route::post('/tolak/{id}', [PeminjamanController::class,'tolak'])->name('peminjaman.tolak');
});

/* PENGEMBALIAN */
use App\Http\Controllers\PengembalianController;
Route::prefix('pengembalian')->group(function(){
    Route::get('/', [PengembalianController::class,'index'])->name('pengembalian.index');
    Route::post('/setujui/{id}', [PengembalianController::class,'setujuiKembali'])->name('pengembalian.setujui');
});

/* LAPORAN */
Route::prefix('laporan')->group(function(){
    Route::get('/', [\App\Http\Controllers\LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/excel', [\App\Http\Controllers\LaporanController::class, 'exportExcel'])->name('laporan.excel');
    Route::get('/pdf', [\App\Http\Controllers\LaporanController::class, 'exportPdf'])->name('laporan.pdf');
});



// User Routes
Route::prefix('user')->group(function() {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    Route::get('/books', [UserController::class, 'books'])->name('user.books');
    Route::post('/pinjam/{id}', [UserController::class, 'pinjam'])->name('user.pinjam');
    Route::get('/daftar-buku', [UserController::class, 'daftarBuku'])->name('user.daftarBuku');
    Route::get('/riwayat/export/pdf', [UserController::class, 'exportPdf'])->name('user.riwayat.pdf');
    Route::get('/riwayat/export/excel', [UserController::class, 'exportExcel'])->name('user.riwayat.excel');
    Route::get('/riwayat', [UserController::class, 'riwayat'])->name('user.riwayat');
    Route::get('/pengembalian', [UserController::class, 'pengembalian'])->name('user.pengembalian');
    Route::get('/pinjaman/konfirmasi/{id}', [UserController::class, 'konfirmasiKembali'])->name('user.konfirmasiKembali');
    Route::post('/pinjaman/kembalikan/{id}', [UserController::class, 'kembalikanBuku'])->name('user.kembalikanBuku');
});