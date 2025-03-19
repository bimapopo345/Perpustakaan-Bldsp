# Routes

File: `routes/web.php`

## Public Routes

```php
// Home & Book Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/book/{id}', [HomeController::class, 'show'])->name('book.show');
Route::get('/book/{id}/read', [BookController::class, 'read'])->name('books.read');
Route::get('/book/{id}/pdf', [BookController::class, 'viewPdf'])->name('books.view-pdf');
```

### Fungsi:

-   `/` - Halaman utama, menampilkan daftar buku
-   `/book/{id}` - Halaman detail buku
-   `/book/{id}/read` - Halaman baca buku
-   `/book/{id}/pdf` - View PDF buku

## Authentication Routes

```php
// Guest Only Routes
Route::middleware('guest')->group(function () {
    // Login Routes
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.attempt');

    // Register Routes
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.attempt');
});

// Logout Route
Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');
```

### Fungsi:

-   `/login` - Form login (GET) dan proses login (POST)
-   `/register` - Form registrasi (GET) dan proses registrasi (POST)
-   `/logout` - Proses logout (POST)

## Member Routes

```php
Route::middleware(['auth', 'role:member'])->group(function () {
    // Dashboard
    Route::get('/member/dashboard', [MemberController::class, 'dashboard'])->name('member.dashboard');

    // Peminjaman Routes
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/{id}', [PeminjamanController::class, 'show'])->name('peminjaman.show');
    Route::get('/book/pinjam/{id}', [PeminjamanController::class, 'create'])->name('peminjaman.create');
    Route::post('/book/pinjam', [PeminjamanController::class, 'store'])->name('peminjaman.store');
});
```

### Fungsi:

-   `/member/dashboard` - Dashboard member
-   `/peminjaman` - List peminjaman user
-   `/peminjaman/{id}` - Detail peminjaman
-   `/book/pinjam/{id}` - Form peminjaman buku
-   `/book/pinjam` (POST) - Proses peminjaman buku

## Admin Routes

```php
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Dashboard
        Route::get('/', function () {
            return redirect()->route('admin.dashboard');
        });
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        // Books Management
        Route::resource('books', AdminBookController::class);

        // Members Management
        Route::get('/members', [AdminMemberController::class, 'index'])->name('members.index');

        // Peminjaman Management
        Route::get('/peminjaman', [AdminPeminjamanController::class, 'index'])
            ->name('peminjaman.index');
        Route::post('/peminjaman/{id}/approve', [AdminPeminjamanController::class, 'approve'])
            ->name('peminjaman.approve');
        Route::post('/peminjaman/{id}/reject', [AdminPeminjamanController::class, 'reject'])
            ->name('peminjaman.reject');
        Route::post('/peminjaman/{id}/return', [AdminPeminjamanController::class, 'return'])
            ->name('peminjaman.return');
    });
```

### Fungsi Admin Books:

-   `GET /admin/books` - List buku
-   `GET /admin/books/create` - Form tambah buku
-   `POST /admin/books` - Simpan buku baru
-   `GET /admin/books/{id}/edit` - Form edit buku
-   `PUT /admin/books/{id}` - Update buku
-   `DELETE /admin/books/{id}` - Hapus buku

### Fungsi Admin Members:

-   `GET /admin/members` - List member

### Fungsi Admin Peminjaman:

-   `GET /admin/peminjaman` - List semua peminjaman
-   `POST /admin/peminjaman/{id}/approve` - Approve peminjaman
-   `POST /admin/peminjaman/{id}/reject` - Reject peminjaman
-   `POST /admin/peminjaman/{id}/return` - Konfirmasi pengembalian

## Middleware

Semua route dilindungi oleh middleware yang sesuai:

### Auth Middleware

-   `auth` - Memastikan user sudah login
-   `guest` - Memastikan user belum login

### Role Middleware

-   `role:admin` - Memastikan user adalah admin
-   `role:member` - Memastikan user adalah member

## Route Parameters

### Required Parameters

-   `{id}` - ID buku atau peminjaman (integer)

### Optional Parameters

-   `status` - Filter status peminjaman (query string)
