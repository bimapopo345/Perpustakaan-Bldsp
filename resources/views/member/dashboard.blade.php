@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header Section -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">Selamat Datang, {{ auth()->user()->name }}</h1>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                    Logout
                </button>
            </form>
        </div>
    </div>

    <!-- Content Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Books Card -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Buku Tersedia</h2>
                <span class="text-3xl font-bold text-indigo-600">{{ \App\Models\Book::count() }}</span>
            </div>
            <a href="{{ route('home') }}" class="text-indigo-600 hover:text-indigo-700 flex items-center">
                Lihat Semua Buku
                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>

        <!-- Profile Card -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Profil Saya</h2>
            <div class="space-y-2">
                <p class="text-gray-600">
                    <span class="font-medium">Nama:</span> {{ auth()->user()->name }}
                </p>
                <p class="text-gray-600">
                    <span class="font-medium">Email:</span> {{ auth()->user()->email }}
                </p>
                <p class="text-gray-600">
                    <span class="font-medium">Status:</span> 
                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-sm">Member Aktif</span>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
