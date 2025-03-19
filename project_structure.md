# Struktur Proyek Perpustakaan

## Ringkasan

Sistem Perpustakaan berbasis Laravel yang memungkinkan pengelolaan buku dan peminjaman dengan dua role utama: admin dan member.

## Struktur Direktori

```
perpustakaan/
├── app/                            # Core application code
│   ├── Http/
│   │   ├── Controllers/           # Controller files
│   │   │   ├── Admin/            # Admin controllers
│   │   │   │   ├── BookController.php
│   │   │   │   ├── MemberController.php
│   │   │   │   └── PeminjamanController.php
│   │   │   ├── Auth/             # Authentication controllers
│   │   │   │   ├── LoginController.php
│   │   │   │   └── RegisterController.php
│   │   │   ├── BookController.php
│   │   │   ├── Controller.php
│   │   │   ├── HomeController.php
│   │   │   ├── MemberController.php
│   │   │   └── PeminjamanController.php
│   │   └── Middleware/           # Middleware files
│   │       ├── Authenticate.php
│   │       ├── CheckRole.php
│   │       └── RedirectIfAuthenticated.php
│   ├── Models/                    # Model files
│   │   ├── Book.php
│   │   ├── Peminjaman.php
│   │   └── User.php
│   └── Providers/                # Service providers
│       └── AppServiceProvider.php
├── bootstrap/                    # Framework bootstrap files
├── config/                       # Configuration files
├── database/                     # Database files
│   ├── migrations/              # Database migrations
│   │   ├── users_table.php
│   │   ├── books_table.php
│   │   └── peminjaman_table.php
│   └── seeders/                # Database seeders
│       ├── AdminSeeder.php
│       └── DatabaseSeeder.php
├── public/                      # Publicly accessible files
│   ├── storage/               # Symlink to storage/app/public
│   │   ├── thumbnails/       # Buku thumbnails
│   │   └── pdfs/            # Buku PDF files
├── resources/                  # Frontend resources
│   ├── css/                  # CSS files
│   ├── js/                   # JavaScript files
│   └── views/                # Blade view files
│       ├── admin/           # Admin views
│       │   ├── books/
│       │   ├── members/
│       │   └── peminjaman/
│       ├── auth/            # Authentication views
│       ├── books/           # Public book views
│       ├── layouts/         # Layout templates
│       ├── member/          # Member views
│       └── peminjaman/      # Peminjaman views
├── routes/                    # Route files
│   └── web.php              # Web routes
├── storage/                  # Storage directory
│   └── app/
│       └── public/          # Public storage
│           ├── thumbnails/  # Book thumbnails
│           └── pdfs/        # Book PDF files
└── tests/                    # Test files
```

## File Penting dan Fungsinya

### Konfigurasi

-   `.env` - Konfigurasi environment
-   `config/*.php` - File konfigurasi aplikasi
-   `composer.json` - Dependency PHP
-   `package.json` - Dependency JavaScript/Node.js

### Routes

-   `routes/web.php` - Mendefinisikan semua route web aplikasi

### Controllers

-   `app/Http/Controllers/Admin/*` - Controller untuk admin panel
-   `app/Http/Controllers/Auth/*` - Controller untuk autentikasi
-   `app/Http/Controllers/*` - Controller untuk fitur umum dan member

### Models

-   `app/Models/Book.php` - Model untuk data buku
-   `app/Models/User.php` - Model untuk data user
-   `app/Models/Peminjaman.php` - Model untuk data peminjaman

### Views

-   `resources/views/admin/*` - View untuk admin panel
-   `resources/views/auth/*` - View untuk halaman autentikasi
-   `resources/views/books/*` - View untuk halaman buku
-   `resources/views/member/*` - View untuk halaman member
-   `resources/views/peminjaman/*` - View untuk halaman peminjaman

### Middleware

-   `app/Http/Middleware/CheckRole.php` - Middleware untuk pengecekan role
-   `app/Http/Middleware/Authenticate.php` - Middleware untuk autentikasi

### Database

-   `database/migrations/*` - File migrasi database
-   `database/seeders/*` - File seeder database

## Dependency Utama

### PHP (composer.json)

-   Laravel Framework
-   Laravel UI
-   Other Laravel dependencies

### JavaScript (package.json)

-   TailwindCSS
-   Axios
-   Laravel Mix

## Storage

Project menggunakan filesystem Laravel untuk menyimpan:

-   Thumbnail buku di `storage/app/public/thumbnails/`
-   File PDF buku di `storage/app/public/pdfs/`

## Environment Variables

Konfigurasi penting di file .env:

-   Database credentials
-   App settings
-   Storage settings
