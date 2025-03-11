<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    /**
     * Menampilkan form peminjaman buku
     */
    public function create(Request $request)
    {
        $bookId = $request->query('id');
        if (!$bookId) {
            return redirect()->route('home');
        }
        $book = Book::findOrFail($bookId);
        
        // Cek apakah user sudah meminjam buku ini dan belum dikembalikan
        $activePinjam = Peminjaman::where('user_id', auth()->id())
            ->where('book_id', $bookId)
            ->whereIn('status', ['menunggu', 'disetujui', 'dipinjam'])
            ->exists();
            
        if ($activePinjam) {
            return back()->with('error', 'Anda sudah meminjam atau mengajukan peminjaman untuk buku ini');
        }
        
        return view('peminjaman.create', compact('book'));
    }

    /**
     * Menyimpan peminjaman baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'tanggal_pinjam' => 'required|date|after_or_equal:today',
            'durasi' => 'required|integer|min:1|max:7'
        ]);

        $book = Book::findOrFail($request->book_id);
        
        // Validasi input
        $request->validate([
            'tanggal_pinjam' => 'required|date|after_or_equal:today',
            'durasi' => 'required|integer|min:1|max:7'
        ]);
        
        // Set tanggal pinjam dan kembali
        $tanggalPinjam = Carbon::parse($request->tanggal_pinjam);
        $tanggalKembali = $tanggalPinjam->copy()->addDays($request->durasi);
        
        // Buat peminjaman baru
        Peminjaman::create([
            'user_id' => auth()->id(),
            'book_id' => $request->book_id,
            'tanggal_pinjam' => $tanggalPinjam,
            'tanggal_kembali' => $tanggalKembali,
            'status' => 'menunggu'
        ]);
        
        return redirect()->route('member.dashboard')
            ->with('success', 'Pengajuan peminjaman berhasil dibuat. Silakan tunggu persetujuan admin.');
    }

    /**
     * Menampilkan daftar peminjaman user yang sedang login
     */
    public function index()
    {
        $peminjaman = Peminjaman::with(['book', 'approver'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);
            
        return view('peminjaman.index', compact('peminjaman'));
    }

    /**
     * Menampilkan detail peminjaman
     */
    public function show($id)
    {
        $peminjaman = Peminjaman::with(['book', 'approver'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);
            
        return view('peminjaman.show', compact('peminjaman'));
    }
}
