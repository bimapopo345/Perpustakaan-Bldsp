<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang digunakan model ini
     */
    protected $table = 'peminjaman';

    /**
     * Atribut yang dapat diisi secara massal
     */
    protected $fillable = [
        'user_id',
        'book_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'tanggal_dikembalikan',
        'status',
        'catatan',
        'approved_by'
    ];

    /**
     * Atribut yang harus diubah menjadi tipe data tertentu
     */
    protected $casts = [
        'tanggal_pinjam' => 'datetime',
        'tanggal_kembali' => 'datetime',
        'tanggal_dikembalikan' => 'datetime',
    ];

    /**
     * Relasi ke model User (peminjam)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke model Book
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Relasi ke model User (admin yang menyetujui)
     */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Cek apakah peminjaman sudah melewati batas waktu
     */
    public function isOverdue()
    {
        if ($this->status !== 'dipinjam') {
            return false;
        }
        return now() > $this->tanggal_kembali;
    }
}
