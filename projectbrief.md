# Sistem Perpustakaan (Library Management System)

## Overview

Sistem manajemen perpustakaan berbasis web yang dibangun menggunakan Laravel 12. Sistem ini memungkinkan pengelolaan buku, anggota, dan transaksi peminjaman buku secara digital.

## Teknologi Utama

-   PHP 8.2
-   Laravel 12.0
-   SQLite Database
-   Tailwind CSS
-   Vite (Frontend Bundler)

## Fitur Utama

1. **Manajemen Buku**

    - Penyimpanan data buku (judul, tahun terbit, deskripsi)
    - Upload thumbnail dan file buku
    - Pencarian dan filter buku

2. **Sistem Peminjaman**

    - Peminjaman buku oleh anggota
    - Tracking status peminjaman (menunggu, disetujui, dipinjam, dikembalikan, terlambat, ditolak)
    - Pencatatan tanggal pinjam dan kembali
    - Approval system oleh admin

3. **Manajemen Pengguna**
    - Multi-role user (admin dan member)
    - Sistem autentikasi
    - Manajemen profil pengguna

## Struktur Database Utama

### Books Table

-   id (Primary Key)
-   judul
-   tahun_terbit
-   deskripsi
-   thumbnail_path
-   file_path
-   timestamps

### Peminjaman Table

-   id (Primary Key)
-   user_id (Foreign Key)
-   book_id (Foreign Key)
-   tanggal_pinjam
-   tanggal_kembali
-   tanggal_dikembalikan
-   status (enum: menunggu, disetujui, dipinjam, dikembalikan, terlambat, ditolak)
-   catatan
-   approved_by (Foreign Key ke users)
-   timestamps

## Konfigurasi Sistem

-   Menggunakan SQLite sebagai database default
-   Session management berbasis database
-   File storage menggunakan local disk
-   Queue system berbasis database
-   Cache storage berbasis database
