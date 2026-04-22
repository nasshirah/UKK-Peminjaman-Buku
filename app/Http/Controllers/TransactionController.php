<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Member;
use App\Models\Book;

class TransactionController extends Controller
{

    public function index()
    {
        $transactions = Transaction::with('member','book')->get();

        return view('transactions.index', compact('transactions'));
    }

    public function kembali($id)
    {
        $transaction = Transaction::find($id);

        $book = Book::find($transaction->book_id);

        // update transaksi
        $transaction->update([
            'tanggal_kembali' => date('Y-m-d'),
            'status' => 'dikembalikan'
        ]);

        // stok buku bertambah
        $book->stok += 1;
        $book->save();

        return redirect('/transactions')->with('success','Buku berhasil dikembalikan');
    }

    public function setujui($id)
    {
        $transaction = Transaction::findOrFail($id);

        if ($transaction->status !== 'menunggu') {
            return back()->with('error', 'Pengajuan ini sudah diproses.');
        }

        $book = Book::findOrFail($transaction->book_id);

        if ($book->stok <= 0) {
            return back()->with('error', 'Stok buku sudah habis, tidak bisa menyetujui.');
        }

        // Update status transaksi jadi dipinjam
        $transaction->update(['status' => 'dipinjam']);

        // Kurangi stok buku
        $book->decrement('stok');

        return back()->with('success', 'Pengajuan peminjaman berhasil disetujui.');
    }


    public function tolak($id)
    {
        $transaction = Transaction::findOrFail($id);

        if ($transaction->status !== 'menunggu') {
            return back()->with('error', 'Pengajuan ini sudah diproses.');
        }

        $transaction->update(['status' => 'ditolak']);

        return back()->with('success', 'Pengajuan peminjaman berhasil ditolak.');
    }

}