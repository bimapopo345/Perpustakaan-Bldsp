<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function read($id)
    {
        $book = Book::findOrFail($id);
        return view('books.read', compact('book'));
    }

    public function viewPdf($id)
    {
        $book = Book::findOrFail($id);
        
        // Debug log untuk memeriksa path file
        Log::info('Attempting to access PDF file:', [
            'file_path' => $book->file_path,
            'full_path' => storage_path('app/public/' . $book->file_path),
            'exists' => Storage::disk('public')->exists($book->file_path)
        ]);
        
        // Periksa file di storage public
        if (!Storage::disk('public')->exists($book->file_path)) {
            abort(404, 'File PDF tidak ditemukan di storage');
        }

        // Dapatkan path fisik file
        $filePath = Storage::disk('public')->path($book->file_path);

        $headers = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $book->judul . '.pdf"',
            'Cache-Control' => 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0',
            'Pragma' => 'no-cache',
            'Expires' => '0',
            'X-Frame-Options' => 'SAMEORIGIN',
            'X-Content-Type-Options' => 'nosniff',
        ];

        // Return file dengan headers yang sesuai
        return response()->file($filePath, $headers);
    }
}
