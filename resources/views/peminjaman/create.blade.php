@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold">Form Peminjaman Buku</h2>
                <a href="{{ url()->previous() }}" 
                   class="text-gray-600 hover:text-gray-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </a>
            </div>
            
            <!-- Informasi Buku -->
            <div class="mb-8 p-4 bg-gray-50 rounded-lg">
                <h3 class="font-semibold mb-4">Informasi Buku</h3>
                <div class="flex items-start space-x-4">
                    @if($book->thumbnail_path)
                        <img src="{{ asset('storage/' . $book->thumbnail_path) }}" 
                             alt="{{ $book->judul }}" 
                             class="w-24 h-32 object-cover rounded">
                    @else
                        <div class="w-24 h-32 bg-gray-200 flex items-center justify-center rounded">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                    @endif
                    <div>
                        <h4 class="font-medium text-lg">{{ $book->judul }}</h4>
                        <p class="text-sm text-gray-600">Tahun Terbit: {{ $book->tahun_terbit }}</p>
                    </div>
                </div>
            </div>

            <!-- Form Peminjaman -->
            <form action="{{ route('peminjaman.store') }}" method="POST">
                @csrf
                <input type="hidden" name="book_id" value="{{ $book->id }}">
                
                <div class="mb-4">
                    <label for="tanggal_pinjam" class="block text-sm font-medium text-gray-700 mb-1">
                        Tanggal Pinjam
                    </label>
                    <input type="date" 
                           id="tanggal_pinjam" 
                           name="tanggal_pinjam" 
                           value="{{ old('tanggal_pinjam', date('Y-m-d')) }}"
                           min="{{ date('Y-m-d') }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                           required>
                    @error('tanggal_pinjam')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="durasi" class="block text-sm font-medium text-gray-700 mb-1">
                        Durasi Peminjaman (Hari)
                    </label>
                    <select id="durasi" 
                            name="durasi"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required>
                        @for($i = 1; $i <= 7; $i++)
                            <option value="{{ $i }}" {{ old('durasi') == $i ? 'selected' : '' }}>
                                {{ $i }} hari
                            </option>
                        @endfor
                    </select>
                    @error('durasi')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Preview Tanggal Kembali -->
                <div class="mb-8 p-4 bg-gray-50 rounded-lg">
                    <p class="text-sm text-gray-600 mb-2">
                        Tanggal kembali akan dihitung otomatis berdasarkan durasi peminjaman yang dipilih.
                    </p>
                    <p class="text-sm font-medium text-gray-900">
                        Maksimal durasi peminjaman adalah 7 hari.
                    </p>
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ url()->previous() }}" 
                       class="inline-flex justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Batal
                    </a>
                    <button type="submit"
                            class="inline-flex justify-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Ajukan Peminjaman
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
