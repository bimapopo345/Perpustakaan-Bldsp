# Controllers

## Struktur Controller

### Admin Controllers

1. BookController (Admin)
2. MemberController (Admin)
3. PeminjamanController (Admin)

### Public Controllers

1. BookController
2. HomeController
3. MemberController
4. PeminjamanController

### Auth Controllers

1. LoginController
2. RegisterController

## Detail Implementasi

### Admin BookController

File: `app/Http/Controllers/Admin/BookController.php`

```php
class BookController extends Controller
{
    // Menampilkan daftar buku
    public function index()
    {
        $books = Book::latest()->paginate(10);
        return view('admin.books.index', compact('books'));
    }

    // Form tambah buku
    public function create()
    {
        return view('admin.books.create');
    }

    // Menyimpan buku baru
    public function store(Request $request)
    {
        // Validasi
        - judul (required, max:255)
        - tahun_terbit (required, numeric, 1900-sekarang)
        - deskripsi (required)
        - thumbnail (required, image, max:2MB)
        - file (required, PDF, max:10MB)

        // Upload files ke storage/app/public
        - thumbnail ke thumbnails/
        - PDF ke pdfs/

        // Simpan data buku
    }

    // Form edit buku
    public function edit(Book $book)
    {
        return view('admin.books.edit', compact('book'));
    }

    // Update data buku
    public function update(Request $request, Book $book)
    {
        // Validasi sama seperti store
        // Update thumbnail/PDF jika ada
        // Hapus file lama jika diganti
        // Update data buku
    }

    // Hapus buku
    public function destroy(Book $book)
    {
        // Hapus file terkait
        // Hapus data buku
    }
}
```

### Admin PeminjamanController

File: `app/Http/Controllers/Admin/PeminjamanController.php`

```php
class PeminjamanController extends Controller
{
    // List semua peminjaman
    public function index(Request $request)
    {
        // Filter berdasarkan status
        $status = $request->get('status', 'semua');
        $query = Peminjaman::with(['user', 'book', 'approver'])
            ->latest();

        if ($status !== 'semua') {
            $query->where('status', $status);
        }

        $peminjaman = $query->paginate(10);
    }

    // Approve peminjaman
    public function approve($id)
    {
        // Validasi status harus 'menunggu'
        // Update status jadi 'disetujui'
        // Set approved_by ke admin yang login
    }

    // Reject peminjaman
    public function reject($id)
    {
        // Validasi status harus 'menunggu'
        // Update status jadi 'ditolak'
        // Set approved_by ke admin yang login
    }

    // Konfirmasi pengembalian
    public function return($id)
    {
        // Validasi status harus 'dipinjam'
        // Update status jadi 'dikembalikan'
        // Set tanggal_dikembalikan ke now()
    }
}
```

### Public PeminjamanController

File: `app/Http/Controllers/PeminjamanController.php`

```php
class PeminjamanController extends Controller
{
    // Form peminjaman
    public function create(Request $request, $id)
    {
        // Cek buku exists
        // Cek belum ada peminjaman aktif
        return view('peminjaman.create', compact('book'));
    }

    // Simpan peminjaman
    public function store(Request $request)
    {
        // Validasi
        - book_id (required, exists)
        - tanggal_pinjam (required, after_or_equal:today)
        - durasi (required, 1-7 hari)

        // Set tanggal kembali = tanggal pinjam + durasi
        // Create peminjaman dengan status 'menunggu'
    }

    // List peminjaman user
    public function index()
    {
        $peminjaman = Peminjaman::with(['book', 'approver'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);
    }

    // Detail peminjaman
    public function show($id)
    {
        // Load peminjaman dengan relasi
        // Validasi kepemilikan
    }
}
```

### HomeController

File: `app/Http/Controllers/HomeController.php`

```php
class HomeController extends Controller
{
    // Halaman utama
    public function index()
    {
        $books = Book::latest()->paginate(12);
        return view('home', compact('books'));
    }

    // Detail buku
    public function show($id)
    {
        $book = Book::findOrFail($id);
        return view('book.show', compact('book'));
    }
}
```

### Auth Controllers

#### LoginController

File: `app/Http/Controllers/Auth/LoginController.php`

-   Menangani proses login
-   Redirect berdasarkan role user

#### RegisterController

File: `app/Http/Controllers/Auth/RegisterController.php`

-   Validasi data registrasi
-   Create user baru dengan role 'member'
-   Auto login setelah register

## Middleware

### CheckRole

File: `app/Http/Middleware/CheckRole.php`

-   Validasi role user
-   Redirect ke home jika tidak punya akses

### Authenticate

File: `app/Http/Middleware/Authenticate.php`

-   Cek user sudah login
-   Redirect ke login jika belum

### RedirectIfAuthenticated

File: `app/Http/Middleware/RedirectIfAuthenticated.php`

-   Redirect user yang sudah login
-   Berbeda redirect berdasarkan role
