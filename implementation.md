# Implementasi Sistem Perpustakaan Digital

## Struktur Database

### Tabel Books

-   `id` - Primary key
-   `judul` - Judul buku
-   `tahun_terbit` - Tahun terbit buku
-   `deskripsi` - Deskripsi buku
-   `thumbnail_path` - Path untuk gambar thumbnail
-   `file_path` - Path untuk file PDF buku
-   timestamps (created_at, updated_at)

### Tabel Peminjaman

-   `id` - Primary key
-   `user_id` - Foreign key ke users
-   `book_id` - Foreign key ke books
-   `tanggal_pinjam` - Tanggal mulai peminjaman
-   `tanggal_kembali` - Tanggal batas pengembalian
-   `tanggal_dikembalikan` - Tanggal buku dikembalikan
-   `status` - Status peminjaman (menunggu, disetujui, dipinjam, dikembalikan, terlambat, ditolak)
-   `catatan` - Catatan peminjaman
-   `approved_by` - Admin yang menyetujui
-   timestamps (created_at, updated_at)

## Alur Sistem

### Alur Member

1. Login/Register sebagai member
2. Melihat daftar buku
3. Membaca detail buku
4. Melakukan peminjaman buku
5. Melihat status peminjaman
6. Membaca buku yang sudah dipinjam

### Alur Admin

1. Login sebagai admin
2. Mengelola data buku (CRUD)
3. Melihat daftar member
4. Mengelola peminjaman:
    - Menyetujui peminjaman
    - Menolak peminjaman
    - Mencatat pengembalian
    - Melihat history peminjaman

## Fitur Utama

### Manajemen Buku

-   Create, Read, Update, Delete buku
-   Upload thumbnail buku
-   Upload file PDF buku
-   Pencarian buku

### Sistem Peminjaman

-   Request peminjaman oleh member
-   Approval/Reject oleh admin
-   Tracking status peminjaman
-   Pengembalian buku
-   Notifikasi keterlambatan

### Keamanan

-   Autentikasi user (login/register)
-   Role-based access control (admin/member)
-   Proteksi file PDF buku
-   Validasi form

## Stack Teknologi

### Backend

-   Laravel 12 Framework
-   MySQL Database
-   PHP 8.2

### Frontend

-   Blade Template Engine
-   Tailwind CSS
-   JavaScript

## API Endpoints

### Public Routes

-   `GET /` - Homepage
-   `GET /book/{id}` - Detail buku
-   `GET /book/{id}/read` - Baca buku
-   `GET /book/{id}/pdf` - View PDF buku

### Member Routes

-   `GET /member/dashboard` - Dashboard member
-   `GET /peminjaman` - List peminjaman
-   `POST /book/pinjam` - Request peminjaman

### Admin Routes

-   `GET /admin/dashboard` - Dashboard admin
-   `GET /admin/books` - Manajemen buku
-   `GET /admin/members` - List member
-   `GET /admin/peminjaman` - Manajemen peminjaman
-   `POST /admin/peminjaman/{id}/approve` - Approve peminjaman
-   `POST /admin/peminjaman/{id}/reject` - Reject peminjaman
-   `POST /admin/peminjaman/{id}/return` - Catat pengembalian
