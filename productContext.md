# Dokumentasi Proyek Perpustakaan Digital

## Struktur File dan Direktori

### Root Directory

```
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   ├── BookController.php
│   │   │   │   ├── MemberController.php
│   │   │   │   └── PeminjamanController.php
│   │   │   ├── Auth/
│   │   │   │   ├── LoginController.php
│   │   │   │   └── RegisterController.php
│   │   │   ├── BookController.php
│   │   │   ├── Controller.php
│   │   │   ├── HomeController.php
│   │   │   ├── MemberController.php
│   │   │   └── PeminjamanController.php
│   │   ├── Middleware/
│   │   │   ├── Authenticate.php
│   │   │   ├── CheckRole.php
│   │   │   └── RedirectIfAuthenticated.php
│   │   └── Kernel.php
│   ├── Models/
│   │   ├── Book.php
│   │   ├── Peminjaman.php
│   │   └── User.php
│   └── Providers/
│       └── AppServiceProvider.php
├── database/
│   ├── migrations/
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   ├── 0001_01_01_000001_create_cache_table.php
│   │   ├── 0001_01_01_000002_create_jobs_table.php
│   │   ├── 2024_03_10_000001_create_books_table.php
│   │   ├── 2025_03_10_130741_add_role_to_users_table.php
│   │   └── 2025_03_11_030449_create_peminjaman_table.php
│   └── seeders/
│       ├── AdminSeeder.php
│       └── DatabaseSeeder.php
├── resources/
│   ├── css/
│   │   └── app.css
│   ├── js/
│   │   ├── app.js
│   │   └── bootstrap.js
│   └── views/
│       ├── admin/
│       │   ├── dashboard.blade.php
│       │   ├── books/
│       │   │   ├── create.blade.php
│       │   │   ├── edit.blade.php
│       │   │   └── index.blade.php
│       │   ├── members/
│       │   │   └── index.blade.php
│       │   └── peminjaman/
│       │       └── index.blade.php
│       ├── auth/
│       │   ├── login.blade.php
│       │   └── register.blade.php
│       ├── books/
│       │   └── read.blade.php
│       ├── layouts/
│       │   └── app.blade.php
│       ├── member/
│       │   └── dashboard.blade.php
│       ├── partials/
│       │   └── book-modal.blade.php
│       ├── peminjaman/
│       │   ├── create.blade.php
│       │   └── index.blade.php
│       └── welcome.blade.php
└── routes/
    ├── web.php
    └── console.php
```

## Deskripsi Komponen Utama

### 1. Controllers

-   **Admin/BookController**: Manajemen buku oleh admin (CRUD)
-   **Admin/MemberController**: Manajemen anggota perpustakaan
-   **Admin/PeminjamanController**: Approval peminjaman, retur buku
-   **BookController**: Menampilkan dan membaca buku
-   **PeminjamanController**: Request peminjaman buku

### 2. Models

-   **Book**: Model untuk data buku
-   **Peminjaman**: Model untuk transaksi peminjaman
-   **User**: Model untuk data pengguna dan admin

### 3. Views

-   **admin/\***: Interface admin untuk manajemen
-   **auth/\***: Halaman login dan register
-   **books/\***: Tampilan buku dan reader
-   **peminjaman/\***: Form dan list peminjaman
-   **layouts & partials**: Template dan komponen reusable

### 4. Database

#### Users Table

```sql
CREATE TABLE users (
    id bigint primary key,
    name varchar(255),
    email varchar(255) unique,
    password varchar(255),
    role enum('admin','member'),
    timestamps
);
```

#### Books Table

```sql
CREATE TABLE books (
    id bigint primary key,
    judul varchar(255),
    tahun_terbit year,
    deskripsi text,
    thumbnail_path varchar(255),
    file_path varchar(255),
    timestamps
);
```

#### Peminjaman Table

```sql
CREATE TABLE peminjaman (
    id bigint primary key,
    user_id bigint foreign key,
    book_id bigint foreign key,
    tanggal_pinjam datetime,
    tanggal_kembali datetime,
    tanggal_dikembalikan datetime null,
    status enum('menunggu','disetujui','dipinjam','dikembalikan','terlambat','ditolak'),
    catatan text null,
    approved_by bigint foreign key null,
    timestamps
);
```

## Routes dan Endpoints

### Public Routes

-   `GET /`: Homepage
-   `GET /book/{id}`: Detail buku
-   `GET /book/{id}/read`: Baca buku
-   `GET /book/{id}/pdf`: View PDF buku

### Auth Routes

-   `GET/POST /login`: Form login dan proses
-   `GET/POST /register`: Form register dan proses
-   `POST /logout`: Logout user

### Member Routes (auth & role:member)

-   `GET /member/dashboard`: Dashboard member
-   `GET /peminjaman`: List peminjaman user
-   `GET /peminjaman/{id}`: Detail peminjaman
-   `GET/POST /book/pinjam/{id}`: Form dan proses peminjaman

### Admin Routes (auth & role:admin)

-   `GET /admin/dashboard`: Dashboard admin
-   Resource routes untuk books
-   `GET /admin/members`: List member
-   `GET /admin/peminjaman`: List semua peminjaman
-   `POST /admin/peminjaman/{id}/approve`: Approve peminjaman
-   `POST /admin/peminjaman/{id}/reject`: Reject peminjaman
-   `POST /admin/peminjaman/{id}/return`: Catat pengembalian

## Status Development

### Fitur yang Sudah Ada

1. Autentikasi & Autorisasi
2. Manajemen Buku (CRUD)
3. Sistem Peminjaman Dasar
4. PDF Reader
5. Role Based Access

### Yang Perlu Dikembangkan

1. Optimasi Response:

    - Chunking untuk response besar
    - Caching untuk query populer
    - Streaming untuk file PDF

2. Peningkatan Fitur:

    - Sistem notifikasi
    - Advanced search
    - Dashboard reporting
    - Batch processing

3. Peningkatan Keamanan:
    - Rate limiting
    - File access protection
    - Input validation
    - Error handling
