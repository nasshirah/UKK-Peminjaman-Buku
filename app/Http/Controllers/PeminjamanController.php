<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Member;
use App\Models\Book;

class PeminjamanController extends Controller
{
    public function peminjaman()
    {
        $menunggu = Peminjaman::with('member','book')->where('status', 'menunggu')->latest()->get();
        $peminjaman = Peminjaman::with('member','book')->whereIn('status', ['menunggu', 'dipinjam', 'ditolak'])->latest()->get();

        return view('peminjaman.request', compact('menunggu', 'peminjaman'));
    }

    public function setujui($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'menunggu') {
            return back()->with('error', 'Pengajuan ini sudah diproses.');
        }

        $book = Book::findOrFail($peminjaman->book_id);

        if ($book->stok <= 0) {
            return back()->with('error', 'Stok buku sudah habis, tidak bisa menyetujui.');
        }

        $peminjaman->update(['status' => 'dipinjam']);
        $book->decrement('stok');

        return back()->with('success', 'Pengajuan peminjaman berhasil disetujui.');
    }

    public function tolak($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'menunggu') {
            return back()->with('error', 'Pengajuan ini sudah diproses.');
        }

        $peminjaman->update(['status' => 'ditolak']);

        return back()->with('success', 'Pengajuan peminjaman berhasil ditolak.');
    }
}
