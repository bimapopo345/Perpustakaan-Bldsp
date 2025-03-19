# Model dan Relasi

## User Model

File: `app/Models/User.php`

```php
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
```

### Atribut

-   `name` - Nama pengguna
-   `email` - Email (unique)
-   `password` - Password (hashed)
-   `role` - Role pengguna (admin/member)
-   `email_verified_at` - Timestamp verifikasi email
-   `remember_token` - Token untuk fitur "remember me"

### Relasi

-   Memiliki banyak peminjaman (sebagai peminjam)
-   Memiliki banyak peminjaman (sebagai admin yang menyetujui)

## Book Model

File: `app/Models/Book.php`

```php
class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'tahun_terbit',
        'deskripsi',
        'thumbnail_path',
        'file_path',
    ];

    public function getThumbnailUrlAttribute()
    {
        if (!$this->thumbnail_path) {
            return null;
        }
        return asset('storage/' . $this->thumbnail_path);
    }

    public function getPdfUrlAttribute()
    {
        if (!$this->file_path) {
            return null;
        }
        return asset('storage/' . $this->file_path);
    }
}
```

### Atribut

-   `judul` - Judul buku
-   `tahun_terbit` - Tahun terbit
-   `deskripsi` - Deskripsi buku
-   `thumbnail_path` - Path ke file thumbnail
-   `file_path` - Path ke file PDF

### Accessor Methods

-   `getThumbnailUrlAttribute()` - Mendapatkan URL thumbnail
-   `getPdfUrlAttribute()` - Mendapatkan URL file PDF

### Relasi

-   Memiliki banyak peminjaman

## Peminjaman Model

File: `app/Models/Peminjaman.php`

```php
class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';

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

    protected $casts = [
        'tanggal_pinjam' => 'datetime',
        'tanggal_kembali' => 'datetime',
        'tanggal_dikembalikan' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function isOverdue()
    {
        if ($this->status !== 'dipinjam') {
            return false;
        }
        return now() > $this->tanggal_kembali;
    }
}
```

### Atribut

-   `user_id` - ID peminjam
-   `book_id` - ID buku yang dipinjam
-   `tanggal_pinjam` - Tanggal peminjaman
-   `tanggal_kembali` - Batas waktu pengembalian
-   `tanggal_dikembalikan` - Tanggal aktual pengembalian
-   `status` - Status peminjaman
-   `catatan` - Catatan peminjaman
-   `approved_by` - ID admin yang menyetujui

### Relasi

-   Belongs to User (peminjam)
-   Belongs to Book (buku yang dipinjam)
-   Belongs to User (admin yang menyetujui)

### Methods

-   `isOverdue()` - Cek apakah peminjaman telah melewati batas waktu

### Status Peminjaman

Status yang mungkin:

-   `menunggu` - Menunggu persetujuan
-   `disetujui` - Peminjaman disetujui
-   `dipinjam` - Buku sedang dipinjam
-   `dikembalikan` - Buku sudah dikembalikan
-   `terlambat` - Melewati batas waktu
-   `ditolak` - Peminjaman ditolak

## Factory & Seeder

-   UserFactory.php - Factory untuk pembuatan data dummy user
-   AdminSeeder.php - Seeder untuk membuat akun admin default
