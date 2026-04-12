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


/* TRANSACTIONS */

Route::prefix('transactions')->group(function(){

    Route::get('/', [TransactionController::class,'index'])->name('transactions.index');
    Route::get('/create', [TransactionController::class,'create'])->name('transactions.create');
    Route::post('/store', [TransactionController::class,'store'])->name('transactions.store');
    Route::get('/kembali/{id}', [TransactionController::class,'kembali'])->name('transactions.kembali');
    Route::get('/setujui/{id}', [TransactionController::class,'setujui'])->name('transactions.setujui');
    Route::get('/tolak/{id}', [TransactionController::class,'tolak'])->name('transactions.tolak');

});



// User Routes
Route::prefix('user')->group(function() {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    Route::get('/books', [UserController::class, 'books'])->name('user.books');
    Route::get('/books/konfirmasi/{id}', [UserController::class, 'konfirmasiPinjam'])->name('user.konfirmasiPinjam');
    Route::post('/books/pinjam', [UserController::class, 'pinjamBuku'])->name('user.pinjamBuku');
    Route::get('/daftar-buku', [UserController::class, 'daftarBuku'])->name('user.daftarBuku');
    Route::get('/pinjaman', [UserController::class, 'pinjaman'])->name('user.pinjaman');
    Route::get('/riwayat', [UserController::class, 'riwayat'])->name('user.riwayat');
});