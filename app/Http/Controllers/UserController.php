<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Transaction;
use Carbon\Carbon;

class UserController extends Controller
{
    
    // DASHBOARD USER
    public function dashboard()
    {
        if (!session('user_id') || session('role') != 'user') {
            return redirect('/');
        }

        $totalBuku = Book::count(); 
        $totalPinjaman = Transaction::where('member_id', session('user_id'))
            ->whereIn('status', ['dipinjam', 'menunggu']) 
            ->count(); 
        
        $totalRiwayat = Transaction::where('member_id', session('user_id'))->count();

        // Ambil 5 riwayat transaksi terbaru
        $riwayatTerbaru = Transaction::with('book')
            ->where('member_id', session('user_id'))
            ->latest()
            ->take(5)
            ->get();

        return view('user.dashboard', compact('totalBuku', 'totalPinjaman', 'totalRiwayat', 'riwayatTerbaru'));
    }

  
    // LIST BUKU (UNTUK PINJAM)
    public function books(Request $request)
    {
        if (!session('user_id') || session('role') != 'user') {
            return redirect('/');
        }

        // Query builder untuk buku
        $query = Book::query();

        // Filter pencarian (server-side, tanpa JavaScript)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                  ->orWhere('penulis', 'like', '%' . $search . '%')
                  ->orWhere('penerbit', 'like', '%' . $search . '%');
            });
        }

        // Filter status stok
        if ($request->filled('filter') && $request->filter != 'all') {
            if ($request->filter == 'tersedia') {
                $query->where('stok', '>', 0);
            } elseif ($request->filter == 'habis') {
                $query->where('stok', '<=', 0);
            }
        }

        $books = $query->latest()->get();

        $pengajuan = Transaction::with('book')
            ->where('member_id', session('user_id'))
            ->whereIn('status', ['menunggu', 'dipinjam', 'ditolak'])
            ->latest()
            ->get();

        return view('user.peminjaman.index', compact('books', 'pengajuan'));
    }

    
    // HALAMAN KONFIRMASI PINJAM
    public function konfirmasiPinjam($id)
    {
    
        if (!session('user_id') || session('role') != 'user') {
            return redirect('/');
        }

        $book = Book::findOrFail($id);

        $sudahAjukan = Transaction::where('member_id', session('user_id'))
            ->where('book_id', $id)
            ->whereIn('status', ['menunggu', 'dipinjam'])
            ->exists();

        return view('user.peminjaman.konfirmasi', compact('book', 'sudahAjukan'));
    }

  
    // DAFTAR BUKU (KOLEKSI)
    public function daftarBuku()
    {
        if (!session('user_id') || session('role') != 'user') {
            return redirect('/');
        }

        $books = Book::latest()->get();

        return view('user.buku.index', compact('books'));
    }

    // RIWAYAT PINJAMAN
    public function riwayat()
    {
        if (!session('user_id') || session('role') != 'user') {
            return redirect('/');
        }

        $transactions = Transaction::with('book')
            ->where('member_id', session('user_id')) 
            ->latest() 
            ->get();

        return view('user.riwayat.index', compact('transactions'));
    }

    // EXPORT PDF RIWAYAT
    public function exportPdf()
    {
        if (!session('user_id') || session('role') != 'user') {
            return redirect('/');
        }

        $transactions = Transaction::with('book')
            ->where('member_id', session('user_id'))
            ->latest()
            ->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('user.riwayat.export_pdf', compact('transactions'));
        return $pdf->download('riwayat_peminjaman_'.date('Ymd_His').'.pdf');
    }

    // EXPORT EXCEL RIWAYAT
    public function exportExcel()
    {
        if (!session('user_id') || session('role') != 'user') {
            return redirect('/');
        }

        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\UserRiwayatExport(session('user_id')), 'riwayat_peminjaman_'.date('Ymd_His').'.xlsx');
    }

    // HALAMAN PENGEMBALIAN / PINJAMAN AKTIF
    public function pinjaman()
    {
        if (!session('user_id') || session('role') != 'user') {
            return redirect('/');
        }

        $transactions = Transaction::with('book')
            ->where('member_id', session('user_id'))
            ->whereIn('status', ['dipinjam', 'menunggu']) 
            ->latest()
            ->get();

        return view('user.pengembalian.index', compact('transactions'));
    }

    // KEMBALIKAN BUKU
    public function kembalikanBuku($id)
    {
        if (!session('user_id') || session('role') != 'user') {
            return redirect('/');
        }

        $transaction = Transaction::where('id', $id)
            ->where('member_id', session('user_id'))
            ->where('status', 'dipinjam')
            ->firstOrFail();

        $book = Book::findOrFail($transaction->book_id);

        // Update status transaksi
        $transaction->update([
            'tanggal_kembali' => date('Y-m-d'),
            'status' => 'dikembalikan',
        ]);

        // Stok buku bertambah kembali
        $book->stok += 1;
        $book->save();

        return redirect()->route('user.pinjaman')->with('success', 'Buku "' . $book->judul . '" berhasil dikembalikan!');
    }

    public function pinjamBuku(Request $request)
    {
        if (!session('user_id') || session('role') != 'user') {
            return redirect('/');
        }

        $request->validate([
            'book_id'         => 'required|exists:books,id',
            'tanggal_pinjam'  => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
        ]);

        $book = Book::findOrFail($request->book_id);

        // Cek stok
        if ($book->stok <= 0) {
            return back()->with('error', 'Maaf, stok buku "' . $book->judul . '" sudah habis.');
        }

        $pengajuanAktif = Transaction::where('member_id', session('user_id'))
            ->where('book_id', $request->book_id)
            ->whereIn('status', ['menunggu', 'dipinjam'])
            ->exists();

        if ($pengajuanAktif) {
            return back()->with('error', 'Kamu sudah memiliki pengajuan aktif untuk buku ini.');
        }

        Transaction::create([
            'member_id'       => session('user_id'),
            'book_id'         => $request->book_id,
            'tanggal_pinjam'  => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status'          => 'menunggu',
        ]);
        return redirect()->route('user.books')->with('success', 'Pengajuan peminjaman buku "' . $book->judul . '" berhasil dikirim! Tunggu persetujuan admin.');
    }
}