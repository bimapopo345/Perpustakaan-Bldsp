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
        $kategoriOptions = Book::getKategoriOptions();
        return view('admin.books.create', compact('kategoriOptions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|max:255',
            'kategori' => 'required|in:' . implode(',', array_keys(Book::getKategoriOptions())),
            'tahun_terbit' => 'required|numeric|min:1900|max:' . date('Y'),
            'deskripsi' => 'required',
            'abstrak_text' => 'nullable|string|max:1000',
            'abstrak_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'file' => 'required|mimes:pdf|max:10240'
        ]);

        $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
        $pdfPath = $request->file('file')->store('pdfs', 'public');

        $data = [
            'judul' => $request->judul,
            'kategori' => $request->kategori,
            'tahun_terbit' => $request->tahun_terbit,
            'deskripsi' => $request->deskripsi,
            'abstrak_text' => $request->abstrak_text,
            'thumbnail_path' => $thumbnailPath,
            'file_path' => $pdfPath
        ];

        if ($request->hasFile('abstrak_image')) {
            $data['abstrak_image_path'] = $request->file('abstrak_image')->store('abstraks', 'public');
        }

        Book::create($data);

        return redirect()->route('admin.books.index')
            ->with('success', 'Buku berhasil ditambahkan.');
    }

    public function edit(Book $book)
    {
        $kategoriOptions = Book::getKategoriOptions();
        return view('admin.books.edit', compact('book', 'kategoriOptions'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'judul' => 'required|max:255',
            'kategori' => 'required|in:' . implode(',', array_keys(Book::getKategoriOptions())),
            'tahun_terbit' => 'required|numeric|min:1900|max:' . date('Y'),
            'deskripsi' => 'required',
            'abstrak_text' => 'nullable|string|max:1000',
            'abstrak_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'file' => 'nullable|mimes:pdf|max:10240'
        ]);

        $data = $request->only(['judul', 'kategori', 'tahun_terbit', 'deskripsi', 'abstrak_text']);

        if ($request->hasFile('thumbnail')) {
            if ($book->thumbnail_path) {
                Storage::disk('public')->delete($book->thumbnail_path);
            }
            $data['thumbnail_path'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        if ($request->hasFile('file')) {
            if ($book->file_path) {
                Storage::disk('public')->delete($book->file_path);
            }
            $data['file_path'] = $request->file('file')->store('pdfs', 'public');
        }

        if ($request->hasFile('abstrak_image')) {
            if ($book->abstrak_image_path) {
                Storage::disk('public')->delete($book->abstrak_image_path);
            }
            $data['abstrak_image_path'] = $request->file('abstrak_image')->store('abstraks', 'public');
        }

        $book->update($data);

        return redirect()->route('admin.books.index')
            ->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(Book $book)
    {
        // Hapus file terkait
        if ($book->thumbnail_path) {
            Storage::disk('public')->delete($book->thumbnail_path);
        }
        if ($book->file_path) {
            Storage::disk('public')->delete($book->file_path);
        }
        if ($book->abstrak_image_path) {
            Storage::disk('public')->delete($book->abstrak_image_path);
        }

        $book->delete();

        return redirect()->route('admin.books.index')
            ->with('success', 'Buku berhasil dihapus.');
    }
}
