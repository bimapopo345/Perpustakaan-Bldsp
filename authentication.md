# Sistem Autentikasi dan Keamanan

## Autentikasi

### Middleware

#### CheckRole Middleware

File: `app/Http/Middleware/CheckRole.php`

```php
public function handle(Request $request, Closure $next, string $role)
{
    if (!$request->user() || $request->user()->role !== $role) {
        return redirect('/');
    }
    return $next($request);
}
```

Fungsi:

-   Memvalidasi role user
-   Memastikan akses sesuai permission
-   Redirect jika tidak memiliki akses

#### Authenticate Middleware

File: `app/Http/Middleware/Authenticate.php`

Laravel default middleware untuk:

-   Mengecek status login user
-   Redirect ke halaman login jika belum login
-   Menyimpan intended URL

#### RedirectIfAuthenticated

File: `app/Http/Middleware/RedirectIfAuthenticated.php`

Middleware untuk:

-   Redirect user yang sudah login
-   Mengarahkan ke dashboard sesuai role

### Login System

#### LoginController

File: `app/Http/Controllers/Auth/LoginController.php`

Fitur:

-   Form login (email & password)
-   Validasi credentials
-   Remember me functionality
-   Redirect berdasarkan role user
-   Rate limiting untuk security

#### RegisterController

File: `app/Http/Controllers/Auth/RegisterController.php`

Fitur:

-   Form registrasi member baru
-   Validasi data registrasi
-   Create user dengan role 'member'
-   Auto login setelah registrasi

## Role System

### Role Types

1. Admin

    - Full access ke admin panel
    - Manajemen buku
    - Manajemen member
    - Approve/reject peminjaman

2. Member
    - View buku
    - Download/read buku
    - Request peminjaman
    - View riwayat peminjaman

### Route Protection

```php
// Admin Routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Admin only routes
});

// Member Routes
Route::middleware(['auth', 'role:member'])->group(function () {
    // Member only routes
});
```

## Security Features

### CSRF Protection

-   CSRF token di semua form
-   VerifyCsrfToken middleware
-   X-CSRF-TOKEN header untuk AJAX

### File Upload Security

1. Thumbnail:

    - Max size: 2MB
    - Format: jpeg, png, jpg
    - Stored in: storage/app/public/thumbnails

2. PDF Files:
    - Max size: 10MB
    - Format: pdf only
    - Stored in: storage/app/public/pdfs

### Password Security

-   Hashing menggunakan bcrypt
-   Minimal 8 karakter
-   Kombinasi huruf dan angka
-   Remember token untuk "remember me"

### Session Security

-   HTTP only cookies
-   Same-site protection
-   Session timeout
-   Secure session handling

### Database Security

-   Prepared statements
-   Query parameterization
-   Foreign key constraints
-   Soft deletes

### Access Control

1. Resource Level:

    ```php
    if ($user->cannot('update', $book)) {
        abort(403);
    }
    ```

2. Route Level:

    ```php
    Route::middleware('role:admin')->group(function () {
        // Protected routes
    });
    ```

3. View Level:
    ```blade
    @if(auth()->user()->role === 'admin')
        <!-- Admin only content -->
    @endif
    ```

### Error Handling

-   Custom error pages
-   Logging system
-   No detailed errors in production

## Environment Variables

Sensitive data di .env:

```env
APP_KEY=base64:...
DB_PASSWORD=...
MAIL_PASSWORD=...
```

## Keamanan File

### Storage Links

```bash
php artisan storage:link
```

### File Permissions

```
storage/
  app/
    public/
      thumbnails/ (775)
      pdfs/ (775)
```

## Security Best Practices

1. Input Validation

    - Server-side validation
    - Sanitize input
    - Validate file uploads

2. Output Escaping

    ```blade
    {{ $data }}  <!-- Auto escaped -->
    {!! $html !!}  <!-- Raw output, use carefully -->
    ```

3. Session Security

    - Regenerate session ID
    - Secure session config
    - Session lifetime limits

4. Database Security

    - Prepared statements
    - Input validation
    - Escape output

5. File Security

    - Validate uploads
    - Secure storage
    - Access control

6. Error Handling
    - Custom error pages
    - Log errors
    - Hide sensitive info
