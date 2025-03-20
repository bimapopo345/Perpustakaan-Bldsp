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
        
        try {
            $peminjaman->update([
                'status' => 'dipinjam',  // Langsung set ke dipinjam
                'approved_by' => auth()->id(),
            ]);
            
            return back()->with('success', 'Peminjaman berhasil disetujui dan buku dapat dipinjam');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menyetujui peminjaman');
        }
    }

    /**
     * Menolak peminjaman
     */
    public function reject(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        
        // Hanya bisa reject yang status menunggu
        if ($peminjaman->status !== 'menunggu') {
            return back()->with('error', 'Hanya peminjaman dengan status menunggu yang dapat ditolak');
        }
        
        try {
            $peminjaman->update([
                'status' => 'ditolak',
                'approved_by' => auth()->id(),
                'catatan' => $request->catatan ?? 'Peminjaman ditolak oleh admin'
            ]);
            
            return back()->with('success', 'Peminjaman berhasil ditolak');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menolak peminjaman');
        }
    }

    /**
     * Mengonfirmasi pengembalian buku dari member
     */
    public function confirmReturn($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        
        // Hanya bisa konfirmasi yang status menunggu konfirmasi kembali
        if ($peminjaman->status !== 'menunggu_konfirmasi_kembali') {
            return back()->with('error', 'Hanya peminjaman dengan status menunggu konfirmasi kembali yang dapat dikonfirmasi');
        }
        
        try {
            $peminjaman->update([
                'status' => 'dikembalikan',
                'approved_by' => auth()->id(),
                'tanggal_dikembalikan' => now()
            ]);
            
            return back()->with('success', 'Pengembalian buku berhasil dikonfirmasi');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat mengkonfirmasi pengembalian');
        }
    }
}
