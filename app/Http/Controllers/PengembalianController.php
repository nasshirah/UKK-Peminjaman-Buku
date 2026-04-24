<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\Book;

class PengembalianController extends Controller
{
    public function index()
    {
        $menungguKembali = Pengembalian::with('peminjaman.member','peminjaman.book')->where('status', 'menunggu')->latest()->get();
        $dikembalikan = Pengembalian::with('peminjaman.member','peminjaman.book')->where('status', 'disetujui')->latest()->get();

        return view('pengembalian.index', compact('menungguKembali', 'dikembalikan'));
    }

    public function setujuiKembali($id)
    {
        $pengembalian = Pengembalian::with('peminjaman')->findOrFail($id);

        if ($pengembalian->status !== 'menunggu') {
            return back()->with('error', 'Pengajuan ini sudah diproses.');
        }

        $peminjaman = $pengembalian->peminjaman;
        $book = Book::findOrFail($peminjaman->book_id);

        // update pengembalian
        $pengembalian->update([
            'status' => 'disetujui'
        ]);

        // update peminjaman
        $peminjaman->update([
            'status' => 'selesai'
        ]);

        // stok buku bertambah
        $book->stok += 1;
        $book->save();

        return redirect()->route('pengembalian.index')->with('success','Pengembalian buku berhasil disetujui.');
    }
}
