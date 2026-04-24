<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
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
        $totalPinjaman = Peminjaman::where('member_id', session('user_id'))
            ->whereIn('status', ['dipinjam', 'menunggu']) 
            ->count(); 
        
        $totalRiwayat = Peminjaman::where('member_id', session('user_id'))->count();

        // Ambil 5 riwayat transaksi terbaru
        $riwayatTerbaru = Peminjaman::with('book')
            ->where('member_id', session('user_id'))
            ->latest()
            ->take(5)
            ->get();

        return view('user.dashboard', compact('totalBuku', 'totalPinjaman', 'totalRiwayat', 'riwayatTerbaru'));
    }

  
    // LIST BUKU (UNTUK PINJAM) *Sekarang difungsikan sebagai status peminjaman*
    public function books(Request $request)
    {
        if (!session('user_id') || session('role') != 'user') {
            return redirect('/');
        }

        // Ambil data peminjaman aktif atau menunggu untuk ditampilkan di tabel
        $pinjamanAktif = Peminjaman::with('book')
            ->where('member_id', session('user_id'))
            ->whereIn('status', ['dipinjam', 'menunggu'])
            ->latest()
            ->get();

        // Ambil semua data peminjaman (termasuk ditolak) untuk tabel lengkap
        $semuaPeminjaman = Peminjaman::with('book')
            ->where('member_id', session('user_id'))
            ->whereIn('status', ['menunggu', 'dipinjam', 'ditolak'])
            ->latest()
            ->get();

        return view('user.peminjaman.index', compact('pinjamanAktif', 'semuaPeminjaman'));
    }

    // HALAMAN PENGEMBALIAN BUKU *Menampilkan buku yang sudah dipinjam*
    public function pengembalian()
    {
        if (!session('user_id') || session('role') != 'user') {
            return redirect('/');
        }

        // Ambil data peminjaman yang sedang aktif (dipinjam) saja
        $pinjamanAktif = Peminjaman::with('book', 'pengembalian')
            ->where('member_id', session('user_id'))
            ->where('status', 'dipinjam')
            ->whereDoesntHave('pengembalian')
            ->latest()
            ->get();

        // Ambil semua data pengembalian (dikembalikan) untuk tabel lengkap
        $semuaPengembalian = Peminjaman::with('book', 'pengembalian')
            ->where('member_id', session('user_id'))
            ->whereHas('pengembalian')
            ->latest()
            ->get();

        return view('user.pengembalian.index', compact('pinjamanAktif', 'semuaPengembalian'));
    }

    
    // PINJAM BUKU LANGSUNG (direct borrow, tanpa persetujuan admin)
    public function pinjam(Request $request, $id)
    {
        if (!session('user_id') || session('role') != 'user') {
            return redirect('/');
        }

        $book = Book::findOrFail($id);

        // Validasi 1: Buku harus tersedia (stok > 0)
        if ($book->stok <= 0) {
            return back()->with('error', 'Maaf, buku "' . $book->judul . '" tidak tersedia saat ini.');
        }

        // Validasi 2: User tidak boleh punya peminjaman aktif atau yang sedang menunggu
        $pinjamAktif = Peminjaman::where('member_id', session('user_id'))
            ->whereIn('status', ['dipinjam', 'menunggu'])
            ->first();

        if ($pinjamAktif) {
            $pesan = $pinjamAktif->status == 'menunggu' ? 'menunggu persetujuan' : 'aktif';
            return back()->with('error', 'Anda masih memiliki peminjaman '.$pesan.' untuk buku "' . $pinjamAktif->book->judul . '".');
        }

        // Simpan transaksi dengan status "menunggu"
        Peminjaman::create([
            'member_id'       => session('user_id'),
            'book_id'         => $book->id,
            'tanggal_pinjam'  => date('Y-m-d'),
            'tanggal_kembali' => $request->tanggal_kembali,
            'status'          => 'menunggu',
        ]);

        return redirect()->route('user.books')
            ->with('success', 'Pengajuan pinjam buku "' . $book->judul . '" berhasil dikirim! Menunggu persetujuan Admin.');
    }

  
    // DAFTAR BUKU (KOLEKSI)
    public function daftarBuku()
    {
        if (!session('user_id') || session('role') != 'user') {
            return redirect('/');
        }

        $books = Book::latest()->get();
        
        // Cek apakah user masih punya peminjaman aktif atau menunggu
        $pinjamAktif = Peminjaman::where('member_id', session('user_id'))
            ->whereIn('status', ['dipinjam', 'menunggu'])
            ->exists();

        return view('user.buku.index', compact('books', 'pinjamAktif'));
    }

    // RIWAYAT PINJAMAN
    public function riwayat()
    {
        if (!session('user_id') || session('role') != 'user') {
            return redirect('/');
        }

        // Ambil gabungan data (Peminjaman)
        $transactions = Peminjaman::with('book', 'pengembalian')
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

        $transactions = Peminjaman::with('book', 'pengembalian')
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

    // HALAMAN KONFIRMASI PENGEMBALIAN BUKU
    public function konfirmasiKembali($id)
    {
        if (!session('user_id') || session('role') != 'user') {
            return redirect('/');
        }

        $trx = Peminjaman::with('book')
            ->where('id', $id)
            ->where('member_id', session('user_id'))
            ->where('status', 'dipinjam')
            ->firstOrFail();

        return view('user.pengembalian.konfirmasi', compact('trx'));
    }

    // KEMBALIKAN BUKU (Ajukan pengembalian - menunggu persetujuan admin)
    public function kembalikanBuku($id)
    {
        if (!session('user_id') || session('role') != 'user') {
            return redirect('/');
        }

        $peminjaman = Peminjaman::where('id', $id)
            ->where('member_id', session('user_id'))
            ->where('status', 'dipinjam')
            ->firstOrFail();

        // Buat record pengembalian baru
        Pengembalian::create([
            'peminjaman_id' => $peminjaman->id,
            'tanggal_kembali' => date('Y-m-d'),
            'status' => 'menunggu',
        ]);

        return redirect()->route('user.pengembalian')->with('success', 'Pengajuan pengembalian buku "' . $peminjaman->book->judul . '" berhasil dikirim! Menunggu persetujuan Admin.');
    }

    public function pinjamBuku(Request $request)
    {
        return redirect()->route('user.books')->with('error', 'Silakan gunakan tombol Pinjam pada halaman daftar buku.');
    }
}