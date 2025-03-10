<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .gradient-background {
            background: linear-gradient(120deg, #4F46E5, #7C3AED, #F472B6);
            background-size: 200% 200%;
            animation: gradient 15s ease infinite;
        }
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
        .floating {
            animation: float 6s ease-in-out infinite;
        }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header with Hero Section -->
    <div class="gradient-background">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Navigation -->
            <nav class="py-4">
                <div class="flex justify-between items-center">
                    <div class="text-2xl font-bold text-white">Perpustakaan Digital</div>
                    <div class="flex gap-4">
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" 
                               class="px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 transition-colors duration-300">
                                Dashboard Admin
                            </a>
                        @else
                            <a href="{{ route('member.dashboard') }}" 
                               class="px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 transition-colors duration-300">
                                Dashboard Member
                            </a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" 
                                    class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700 transition-colors duration-300">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" 
                           class="px-4 py-2 rounded-lg bg-white/20 text-white hover:bg-white/30 transition-colors duration-300">
                            Login
                        </a>
                        <a href="{{ route('register') }}" 
                           class="px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 transition-colors duration-300">
                            Register
                        </a>
                    @endauth
                </div>
                </div>
            </nav>

            <!-- Hero Section -->
            <div class="py-16 text-center">
                <h1 class="text-4xl md:text-6xl font-bold text-white mb-6">
                    Jelajahi Dunia Pengetahuan
                </h1>
                <p class="text-lg md:text-xl text-white/80 mb-8">
                    Temukan ribuan buku digital untuk meningkatkan wawasan Anda
                </p>
                <div class="relative max-w-3xl mx-auto">
                    <form action="{{ route('home') }}" method="GET" class="flex gap-4">
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Cari judul buku..."
                               class="w-full px-6 py-4 rounded-xl border-0 focus:ring-2 focus:ring-indigo-500 
                                      shadow-lg placeholder-gray-400">
                        <button type="submit" 
                                class="px-8 py-4 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 
                                       transition-colors duration-300 shadow-lg">
                            Cari
                        </button>
                    </form>
                    <!-- Floating Decorative Elements -->
                    <div class="absolute -top-20 -left-20 w-40 h-40 bg-purple-400/30 rounded-full filter blur-3xl floating"></div>
                    <div class="absolute -bottom-20 -right-20 w-40 h-40 bg-blue-400/30 rounded-full filter blur-3xl floating" style="animation-delay: -2s"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Books Grid Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @if(request('search'))
            <div class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-900">
                    Hasil pencarian untuk "{{ request('search') }}"
                </h2>
            </div>
        @endif

        @if($books->isEmpty())
            <div class="text-center py-12">
                <img src="https://illustrations.popsy.co/white/resistance-band.svg" 
                     alt="No results" class="w-48 h-48 mx-auto mb-6">
                <p class="text-gray-500 text-lg">Tidak ada buku yang ditemukan.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($books as $book)
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden card-hover cursor-pointer"
                         onclick="window.dispatchEvent(new CustomEvent('book-selected', { detail: {{ $book->id }} }))">
                        <div class="aspect-w-3 aspect-h-4 relative overflow-hidden">
                            @if($book->thumbnail_path)
                                <img src="{{ asset('storage/' . $book->thumbnail_path) }}" 
                                     alt="Cover {{ $book->judul }}"
                                     class="w-full h-64 object-cover transform transition-transform duration-300 hover:scale-105">
                            @else
                                <div class="w-full h-64 bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 hover:opacity-100 transition-opacity duration-300 flex items-end">
                                <div class="p-4 w-full text-center">
                                    <p class="text-white text-sm font-medium">Klik untuk detail</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-2 line-clamp-2">{{ $book->judul }}</h3>
                            <p class="text-sm text-gray-600 mb-4">Tahun: {{ $book->tahun_terbit }}</p>
                            <p class="text-sm text-gray-500 line-clamp-3">{{ $book->deskripsi }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $books->links() }}
            </div>
        @endif
    </div>

    <!-- Book Modal Component -->
    @include('partials.book-modal')
</body>
</html>
