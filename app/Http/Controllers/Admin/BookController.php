<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::latest()->paginate(10);
        return view('admin.books.index', compact('books'));
    }

    public function create()
    {
        return view('admin.books.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'file' => 'required|mimes:pdf|max:10240',
            'tahun_terbit' => 'required|integer|min:1900|max:' . date('Y'),
            'deskripsi' => 'required|string'
        ]);

        $file = $request->file('file');
        $filePath = $file->store('books', 'public');

        Book::create([
            'judul' => $request->judul,
            'file_path' => $filePath,
            'tahun_terbit' => $request->tahun_terbit,
            'deskripsi' => $request->deskripsi
        ]);

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil ditambahkan');
    }

    public function edit(Book $book)
    {
        return view('admin.books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'file' => 'nullable|mimes:pdf|max:10240',
            'tahun_terbit' => 'required|integer|min:1900|max:' . date('Y'),
            'deskripsi' => 'required|string'
        ]);

        $data = [
            'judul' => $request->judul,
            'tahun_terbit' => $request->tahun_terbit,
            'deskripsi' => $request->deskripsi
        ];

        if ($request->hasFile('file')) {
            // Hapus file lama
            if ($book->file_path) {
                Storage::disk('public')->delete($book->file_path);
            }
            // Upload file baru
            $file = $request->file('file');
            $data['file_path'] = $file->store('books', 'public');
        }

        $book->update($data);

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil diperbarui');
    }

    public function destroy(Book $book)
    {
        if ($book->file_path) {
            Storage::disk('public')->delete($book->file_path);
        }
        
        $book->delete();

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil dihapus');
    }
}
