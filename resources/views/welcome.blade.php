@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <div class="bg-white rounded-lg shadow-lg p-6 md:p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Selamat Datang di Perpustakaan</h1>
        <p class="text-gray-600 mb-6">
            Sistem manajemen perpustakaan modern untuk memudahkan pengelolaan buku dan peminjaman.
        </p>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-blue-50 p-6 rounded-lg">
                <h3 class="text-xl font-semibold text-blue-700 mb-2">Koleksi Buku</h3>
                <p class="text-gray-600">Akses katalog lengkap koleksi buku perpustakaan.</p>
            </div>
            <div class="bg-green-50 p-6 rounded-lg">
                <h3 class="text-xl font-semibold text-green-700 mb-2">Peminjaman</h3>
                <p class="text-gray-600">Kelola peminjaman dan pengembalian buku dengan mudah.</p>
            </div>
            <div class="bg-purple-50 p-6 rounded-lg">
                <h3 class="text-xl font-semibold text-purple-700 mb-2">Keanggotaan</h3>
                <p class="text-gray-600">Daftar sebagai anggota untuk akses fitur lengkap.</p>
            </div>
        </div>
    </div>
</div>
@endsection
