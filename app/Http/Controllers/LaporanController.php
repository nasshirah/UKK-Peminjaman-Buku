<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\Book;
use App\Models\Member;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // Filter berdasarkan tanggal
        $dari = $request->dari;
        $sampai = $request->sampai;
        $status = $request->status;

        $query = Peminjaman::with('member', 'book', 'pengembalian');

        if ($dari) {
            $query->whereDate('tanggal_pinjam', '>=', $dari);
        }

        if ($sampai) {
            $query->whereDate('tanggal_pinjam', '<=', $sampai);
        }

        if ($status && $status != 'semua') {
            $query->where('status', $status);
        }

        $transactions = $query->latest()->get();

        // Statistik ringkasan
        $totalTransaksi = $transactions->count();
        $totalDipinjam = $transactions->where('status', 'dipinjam')->count();
        $totalDikembalikan = $transactions->where('status', 'selesai')->count();
        $totalMenunggu = $transactions->where('status', 'menunggu')->count();
        $totalDitolak = $transactions->where('status', 'ditolak')->count();

        // Data tambahan
        $totalBuku = Book::count();
        $totalAnggota = Member::where('role', 'user')->count();

        return view('laporan.index', compact(
            'transactions', 'totalTransaksi', 'totalDipinjam',
            'totalDikembalikan', 'totalMenunggu', 'totalDitolak',
            'totalBuku', 'totalAnggota',
            'dari', 'sampai', 'status'
        ));
    }

    public function getFilteredData($request)
    {
        $dari = $request->dari;
        $sampai = $request->sampai;
        $status = $request->status;

        $query = Peminjaman::with('member', 'book', 'pengembalian');

        if ($dari) {
            $query->whereDate('tanggal_pinjam', '>=', $dari);
        }
        if ($sampai) {
            $query->whereDate('tanggal_pinjam', '<=', $sampai);
        }
        if ($status && $status != 'semua') {
            $query->where('status', $status);
        }

        $transactions = $query->latest()->get();

        $totalTransaksi = $transactions->count();
        $totalDipinjam = $transactions->where('status', 'dipinjam')->count();
        $totalDikembalikan = $transactions->where('status', 'selesai')->count();
        $totalMenunggu = $transactions->where('status', 'menunggu')->count();
        $totalDitolak = $transactions->where('status', 'ditolak')->count();

        return compact(
            'transactions', 'totalTransaksi', 'totalDipinjam',
            'totalDikembalikan', 'totalMenunggu', 'totalDitolak',
            'dari', 'sampai', 'status'
        );
    }

    public function exportPdf(Request $request)
    {
        $data = $this->getFilteredData($request);
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('laporan.pdf', $data);
        return $pdf->download('Laporan_Peminjaman_'.date('Y-m-d').'.pdf');
    }

    public function exportExcel(Request $request)
    {
        $data = $this->getFilteredData($request);
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\AdminLaporanExport($data), 'Laporan_Peminjaman_'.date('Y-m-d').'.xlsx');
    }
}
