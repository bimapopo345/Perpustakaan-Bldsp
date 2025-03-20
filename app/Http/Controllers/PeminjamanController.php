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
    public function create(Request $request, $id)
    {
        $bookId = $id;
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
     * Store a new borrow request
     */
    public function store(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'tanggal_pinjam' => 'required|date|after_or_equal:today',
            'tanggal_kembali' => [
                'required',
                'date',
                'after:tanggal_pinjam',
                function ($attribute, $value, $fail) use ($request) {
                    $start = Carbon::parse($request->tanggal_pinjam);
                    $end = Carbon::parse($value);
                    $diffDays = floor(($end->timestamp - $start->timestamp) / (60 * 60 * 24));
                    \Log::info('Durasi: ' . $diffDays . ' days', [
                        'start' => $start->toDateString(),
                        'end' => $end->toDateString(),
                        'start_ts' => $start->timestamp,
                        'end_ts' => $end->timestamp
                    ]);
                    
                    if ($diffDays < 1 || $diffDays > 7) {
                        $fail('Durasi peminjaman harus antara 1-7 hari.');
                    }
                },
            ],
        ]);

        // Check if user already has active borrow for this book
        $activePinjam = Peminjaman::where('user_id', auth()->id())
            ->where('book_id', $validated['book_id'])
            ->whereIn('status', ['menunggu', 'disetujui', 'dipinjam', 'menunggu_konfirmasi_kembali'])
            ->exists();
            
        if ($activePinjam) {
            return redirect()
                ->route('peminjaman.create', $validated['book_id'])
                ->withInput()
                ->withErrors(['book_id' => 'Anda sudah meminjam atau mengajukan peminjaman untuk buku ini']);
        }


        try {
            // Create new borrow request
            Peminjaman::create([
                'user_id' => auth()->id(),
                'book_id' => $validated['book_id'],
                'tanggal_pinjam' => Carbon::parse($validated['tanggal_pinjam']),
                'tanggal_kembali' => Carbon::parse($validated['tanggal_kembali']),
                'status' => 'menunggu'
            ]);

            return redirect()
                ->route('member.dashboard')
                ->with('success', 'Pengajuan peminjaman berhasil dibuat. Silakan tunggu persetujuan admin.');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat mengajukan peminjaman. Silakan coba lagi.');
        }
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

    /**
     * Mengajukan pengembalian buku
     */
    public function return($id)
    {
        $peminjaman = Peminjaman::where('user_id', auth()->id())
            ->where('status', 'dipinjam')
            ->findOrFail($id);
        
        $peminjaman->update([
            'status' => 'menunggu_konfirmasi_kembali',
            'tanggal_dikembalikan' => now()
        ]);
        
        return redirect()->route('member.dashboard')
            ->with('success', 'Pengajuan pengembalian buku berhasil. Menunggu konfirmasi admin.');
    }
}
