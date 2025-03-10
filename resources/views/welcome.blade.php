<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan Digital - BSIP SDLP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-white">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <span class="text-xl font-bold text-gray-800">Perpustakaan Digital</span>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-gray-900">Beranda</a>
                    <a href="{{ route('home') }}#koleksi" class="text-gray-700 hover:text-gray-900">Koleksi</a>
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-gray-900">Admin</a>
                </div>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white">
        <div class="max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl font-extrabold sm:text-5xl md:text-6xl">
                    Selamat Datang di
                </h1>
                <p class="mt-3 max-w-md mx-auto text-base sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                    Perpustakaan Digital BSIP SDLP
                </p>
                <div class="mt-10">
                    <a href="#koleksi" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-blue-700 bg-white hover:bg-gray-50">
                        Lihat Koleksi
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="max-w-3xl mx-auto">
            <form action="{{ route('home') }}" method="GET" class="mt-1 flex">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari judul buku..."
                       class="block w-full rounded-l-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                <button type="submit" 
                        class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-r-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Cari
                </button>
            </form>
        </div>
    </div>

    <!-- Books Section -->
    <div id="koleksi" class="bg-gray-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Koleksi Buku Digital
                </h2>
                <p class="mt-3 max-w-2xl mx-auto text-xl text-gray-500 sm:mt-4">
                    Temukan berbagai koleksi buku digital kami
                </p>
            </div>

            <div class="mt-12 grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
                @foreach($books as $book)
                    <div class="group relative bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300"
                         x-data
                         @click="$dispatch('show-book', {{ $book->id }})">
                        <div class="aspect-w-3 aspect-h-4">
                            @if($book->thumbnail_path)
                                <img src="{{ asset('storage/' . $book->thumbnail_path) }}" 
                                     alt="Cover {{ $book->judul }}"
                                     class="w-full h-64 object-cover">
                            @else
                                <div class="w-full h-64 bg-gray-200 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $book->judul }}</h3>
                            <p class="text-sm text-gray-600">Tahun: {{ $book->tahun_terbit }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $books->links() }}
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="text-center text-gray-400">
                <p>&copy; {{ date('Y') }} Perpustakaan Digital BSIP SDLP. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Book Modal -->
    @include('partials.book-modal')
</body>
</html>
