<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::query();

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where('judul', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
        }

        $books = $query->latest()->paginate(12);

        return view('home', compact('books'));
    }

    public function show($id)
    {
        $book = Book::findOrFail($id);
        
        return response()->json([
            'id' => $book->id,
            'judul' => $book->judul,
            'tahun_terbit' => $book->tahun_terbit,
            'deskripsi' => $book->deskripsi,
            'thumbnail_path' => $book->thumbnail_path ? asset('storage/' . $book->thumbnail_path) : null,
            'file_path' => $book->file_path ? asset('storage/' . $book->file_path) : null,
        ]);
    }
}
