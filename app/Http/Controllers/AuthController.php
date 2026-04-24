<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Member;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    // =========================
    // HALAMAN LOGIN
    // =========================
    public function login()
    {
        return view('auth.login');
    }


    // =========================
    // PROSES LOGIN
    // =========================
    public function loginProcess(Request $request)
    {

        // VALIDASI
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // CEK USER DI MEMBERS
        $user = Member::where('email', $request->email)->first();

        if(!$user){
            return back()->with('error','User tidak ditemukan');
        }

        // CEK PASSWORD
        if(!Hash::check($request->password, $user->password)){
            return back()->with('error','Password salah');
        }

        // SIMPAN SESSION
        session([
            'user_id' => $user->id,
            'role' => $user->role,
            'nama' => $user->nama
        ]);

        // REDIRECT BERDASARKAN ROLE
        if($user->role === 'admin'){
            return redirect('/dashboard');
        }

        if($user->role === 'user'){
            return redirect('/user/dashboard');
        }

        // fallback
        return redirect('/');
    }


    // =========================
    // DASHBOARD ADMIN
    // =========================
    public function dashboard()
    {

        // PROTEKSI ADMIN
        if(!session('user_id') || session('role') !== 'admin'){
            return redirect('/');
        }

        // STATISTIK
        $totalBuku = Book::count();
        $totalAnggota = Member::count();
        $totalPeminjaman = Peminjaman::count();

        // GRAFIK DATA (Berdasarkan status transaksi)
        $grafikStatus = [
            'pending' => Peminjaman::where('status', 'menunggu')->count(),
            'dipinjam' => Peminjaman::where('status', 'dipinjam')->count(),
            'dikembalikan' => Peminjaman::where('status', 'selesai')->count(),
            'ditolak' => Peminjaman::where('status', 'ditolak')->count(),
        ];

        return view('dashboard.index', compact(
            'totalBuku',
            'totalAnggota',
            'totalPeminjaman',
            'grafikStatus'
        ));
    }


    // =========================
    // LOGOUT
    // =========================
    public function logout()
    {
        session()->flush();
        return redirect('/');
    }

}