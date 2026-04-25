<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{

    public function index()
    {
        $books = Book::all();

        return view('books.index', compact('books'));
    }


    public function create()
    {
        return view('books.create');
    }


    public function store(Request $request)
    {
        $data = [
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'tahun' => $request->tahun,
            'stok' => $request->stok
        ];

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('books', 'public');
        }

        Book::create($data);

        return redirect('/books')->with('success','Buku berhasil ditambahkan');
    }


    public function edit($id)
    {
        $book = Book::find($id);

        return view('books.edit', compact('book'));
    }


    public function update(Request $request, $id)
    {
        $book = Book::find($id);

        $data = [
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'tahun' => $request->tahun,
            'stok' => $request->stok
        ];

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($book->gambar && Storage::disk('public')->exists($book->gambar)) {
                Storage::disk('public')->delete($book->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('books', 'public');
        }

        $book->update($data);

        return redirect('/books')->with('success','Buku berhasil diupdate');
    }


    public function delete($id)
    {
        $book = Book::find($id);

        // Hapus gambar jika ada
        if ($book->gambar && Storage::disk('public')->exists($book->gambar)) {
            Storage::disk('public')->delete($book->gambar);
        }

        $book->delete();

        return redirect('/books')->with('success','Buku berhasil dihapus');
    }

}