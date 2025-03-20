<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'judul',
        'kategori',
        'tahun_terbit',
        'deskripsi',
        'abstrak_text',
        'abstrak_image_path',
        'thumbnail_path',
        'file_path',
    ];

    /**
     * Get the URL for the book's thumbnail.
     */
    public function getThumbnailUrlAttribute()
    {
        if (!$this->thumbnail_path) {
            return null;
        }
        return asset('storage/' . $this->thumbnail_path);
    }

    /**
     * Get the URL for the book's PDF file.
     */
    public function getPdfUrlAttribute()
    {
        if (!$this->file_path) {
            return null;
        }
        return asset('storage/' . $this->file_path);
    }

    /**
     * Get the URL for the book's abstrak image.
     */
    public function getAbstrakImageUrlAttribute()
    {
        if (!$this->abstrak_image_path) {
            return null;
        }
        return asset('storage/' . $this->abstrak_image_path);
    }

    /**
     * Get available kategori options.
     */
    public static function getKategoriOptions()
    {
        return [
            'Fiksi' => 'Fiksi',
            'Non-Fiksi' => 'Non-Fiksi',
            'Pendidikan' => 'Pendidikan',
            'Sejarah' => 'Sejarah',
            'Teknologi' => 'Teknologi',
            'Lainnya' => 'Lainnya',
        ];
    }
}
