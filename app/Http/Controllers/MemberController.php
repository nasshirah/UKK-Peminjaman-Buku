<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{

    // LIST DATA ANGGOTA
    public function index()
    {
        $members = Member::latest()->get(); // biar data terbaru di atas
        return view('members.index', compact('members'));
    }


    // HALAMAN TAMBAH
    public function create()
    {
        return view('members.create');
    }


    // SIMPAN DATA
    public function store(Request $request)
    {
        // VALIDASI
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:members,email',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,user'
        ]);

        // SIMPAN DATA
        Member::create([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']), // WAJIB HASH
            'role' => $validated['role']
        ]);

        return redirect()->route('members.index')
            ->with('success','Anggota berhasil ditambahkan');
    }


    // HALAMAN EDIT
    public function edit($id)
    {
        $member = Member::findOrFail($id);
        return view('members.edit', compact('member'));
    }


    // UPDATE DATA
    public function update(Request $request, $id)
    {
        $member = Member::findOrFail($id);

        // VALIDASI
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:members,email,'.$id,
            'role' => 'required|in:admin,user',
            'password' => 'nullable|min:6'
        ]);

        // DATA UPDATE
        $data = [
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'role' => $validated['role']
        ];

        // UPDATE PASSWORD (OPSIONAL)
        if(!empty($validated['password'])){
            $data['password'] = Hash::make($validated['password']);
        }

        $member->update($data);

        return redirect()->route('members.index')
            ->with('success','Anggota berhasil diupdate');
    }


    // HAPUS DATA
    public function delete($id)
    {
        $member = Member::findOrFail($id);
        $member->delete();

        return redirect()->route('members.index')
            ->with('success','Anggota berhasil dihapus');
    }

}