<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'judul',
        'file_path',
        'tahun_terbit',
        'deskripsi'
    ];

    protected $casts = [
        'tahun_terbit' => 'integer',
    ];
}
