<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

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
        Book::create([
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'tahun' => $request->tahun,
            'stok' => $request->stok
        ]);

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

        $book->update([
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'tahun' => $request->tahun,
            'stok' => $request->stok
        ]);

        return redirect('/books')->with('success','Buku berhasil diupdate');
    }


    public function delete($id)
    {
        $book = Book::find($id);

        $book->delete();

        return redirect('/books')->with('success','Buku berhasil dihapus');
    }

}