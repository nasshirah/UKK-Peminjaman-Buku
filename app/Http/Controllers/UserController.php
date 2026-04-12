<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Transaction;
use Carbon\Carbon;

class UserController extends Controller
{
    // =========================
    // DASHBOARD USER
    // =========================
    public function dashboard()
    {
        // Proteksi untuk memastikan hanya user yang bisa mengakses halaman dashboard
        if (!session('user_id') || session('role') != 'user') {
            return redirect('/');
        }

        // Mengambil data total buku dan total pinjaman aktif
        $totalBuku = Book::count(); // Total jumlah buku
        $totalPinjaman = Transaction::where('member_id', session('user_id'))
            ->where('status', 'dipinjam') // Hanya pinjaman yang aktif
            ->count(); // Total pinjaman aktif

        // Menampilkan dashboard user dengan data yang diambil
        return view('user.dashboard', compact('totalBuku', 'totalPinjaman'));
    }

    // =========================
    // LIST BUKU (UNTUK PINJAM)
    // =========================
    public function books(Request $request)
    {
        // Proteksi untuk memastikan hanya user yang bisa mengakses halaman daftar buku
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

        // Mengambil pengajuan peminjaman user yang sedang aktif (menunggu / dipinjam / ditolak)
        $pengajuan = Transaction::with('book')
            ->where('member_id', session('user_id'))
            ->whereIn('status', ['menunggu', 'dipinjam', 'ditolak'])
            ->latest()
            ->get();

        return view('user.peminjaman.index', compact('books', 'pengajuan'));
    }

    // =========================
    // HALAMAN KONFIRMASI PINJAM
    // =========================
    public function konfirmasiPinjam($id)
    {
        // Proteksi
        if (!session('user_id') || session('role') != 'user') {
            return redirect('/');
        }

        $book = Book::findOrFail($id);

        // Cek apakah sudah ada pengajuan aktif
        $sudahAjukan = Transaction::where('member_id', session('user_id'))
            ->where('book_id', $id)
            ->whereIn('status', ['menunggu', 'dipinjam'])
            ->exists();

        return view('user.peminjaman.konfirmasi', compact('book', 'sudahAjukan'));
    }

    // =========================
    // DAFTAR BUKU (KOLEKSI)
    // =========================
    public function daftarBuku()
    {
        // Proteksi untuk memastikan hanya user yang bisa mengakses halaman daftar buku
        if (!session('user_id') || session('role') != 'user') {
            return redirect('/');
        }

        // Mengambil semua koleksi buku
        $books = Book::latest()->get();

        // Menampilkan halaman daftar buku
        return view('user.buku.index', compact('books'));
    }

    // =========================
    // PENGEMBALIAN / PINJAMAN AKTIF
    // =========================
    public function pinjaman()
    {
        // Proteksi untuk memastikan hanya user yang bisa mengakses halaman pinjaman aktif
        if (!session('user_id') || session('role') != 'user') {
            return redirect('/');
        }

        // Mengambil daftar transaksi dengan status dipinjam untuk user yang login
        $transactions = Transaction::with('book')
            ->where('member_id', session('user_id'))
            ->where('status', 'dipinjam') // Hanya transaksi dengan status dipinjam
            ->latest()
            ->get();

        // Menampilkan pinjaman aktif
        return view('user.pinjaman.index', compact('transactions'));
    }

    // =========================
    // RIWAYAT PINJAMAN
    // =========================
    public function riwayat()
    {
        // Proteksi untuk memastikan hanya user yang bisa mengakses halaman riwayat
        if (!session('user_id') || session('role') != 'user') {
            return redirect('/');
        }

        // Mengambil riwayat transaksi user
        $transactions = Transaction::with('book')
            ->where('member_id', session('user_id')) // Filter berdasarkan user yang login
            ->latest() // Mengurutkan berdasarkan yang terbaru
            ->get();

        // Menampilkan riwayat pinjaman
        return view('user.riwayat.index', compact('transactions'));
    }

    // =========================
    // PROSES PENGAJUAN PINJAM BUKU
    // =========================
    public function pinjamBuku(Request $request)
    {
        // Proteksi
        if (!session('user_id') || session('role') != 'user') {
            return redirect('/');
        }

        // Validasi input
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

        // Cek apakah sudah ada pengajuan aktif (menunggu atau dipinjam) untuk buku yang sama
        $pengajuanAktif = Transaction::where('member_id', session('user_id'))
            ->where('book_id', $request->book_id)
            ->whereIn('status', ['menunggu', 'dipinjam'])
            ->exists();

        if ($pengajuanAktif) {
            return back()->with('error', 'Kamu sudah memiliki pengajuan aktif untuk buku ini.');
        }

        // Buat pengajuan peminjaman dengan status menunggu
        Transaction::create([
            'member_id'       => session('user_id'),
            'book_id'         => $request->book_id,
            'tanggal_pinjam'  => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status'          => 'menunggu',
        ]);

        // Stok TIDAK dikurangi di sini, dikurangi saat admin menyetujui
        return redirect()->route('user.books')->with('success', 'Pengajuan peminjaman buku "' . $book->judul . '" berhasil dikirim! Tunggu persetujuan admin.');
    }
}