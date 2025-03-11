<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    /**
     * Menampilkan daftar peminjaman
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'semua');
        
        $query = Peminjaman::with(['user', 'book', 'approver'])
            ->latest();
            
        // Filter berdasarkan status
        if ($status !== 'semua') {
            $query->where('status', $status);
        }
        
        $peminjaman = $query->paginate(10);
        
        return view('admin.peminjaman.index', compact('peminjaman', 'status'));
    }

    /**
     * Menyetujui peminjaman
     */
    public function approve($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        
        // Hanya bisa approve yang status menunggu
        if ($peminjaman->status !== 'menunggu') {
            return back()->with('error', 'Hanya peminjaman dengan status menunggu yang dapat disetujui');
        }
        
        $peminjaman->update([
            'status' => 'disetujui',
            'approved_by' => auth()->id(),
        ]);
        
        return back()->with('success', 'Peminjaman berhasil disetujui');
    }

    /**
     * Menolak peminjaman
     */
    public function reject($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        
        // Hanya bisa reject yang status menunggu
        if ($peminjaman->status !== 'menunggu') {
            return back()->with('error', 'Hanya peminjaman dengan status menunggu yang dapat ditolak');
        }
        
        $peminjaman->update([
            'status' => 'ditolak',
            'approved_by' => auth()->id(),
        ]);
        
        return back()->with('success', 'Peminjaman berhasil ditolak');
    }

    /**
     * Mengonfirmasi pengembalian buku
     */
    public function return($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        
        // Hanya bisa return yang status dipinjam
        if ($peminjaman->status !== 'dipinjam') {
            return back()->with('error', 'Hanya peminjaman dengan status dipinjam yang dapat dikembalikan');
        }
        
        $peminjaman->update([
            'status' => 'dikembalikan',
            'tanggal_dikembalikan' => now(),
        ]);
        
        return back()->with('success', 'Buku berhasil dikembalikan');
    }
}
