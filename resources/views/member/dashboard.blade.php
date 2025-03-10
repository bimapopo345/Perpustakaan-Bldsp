<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Dashboard - Perpustakaan Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="gradient-background">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold text-white">Member Dashboard</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('home') }}" class="text-white hover:text-gray-200 transition-colors duration-200">
                        Beranda
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Welcome Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8">
            <div class="p-8 bg-gradient-to-r from-indigo-600 to-purple-600">
                <h2 class="text-3xl font-bold text-white mb-2">Selamat Datang, {{ auth()->user()->name }}</h2>
                <p class="text-indigo-100">Jelajahi koleksi buku digital kami yang lengkap</p>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Books Card -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden card-hover">
                <div class="p-8">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-semibold text-gray-800">Total Buku</h3>
                        <div class="bg-indigo-500 text-white p-3 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-gray-900 mb-4">{{ \App\Models\Book::count() }}</p>
                    <a href="{{ route('home') }}" class="text-indigo-600 hover:text-indigo-700 inline-flex items-center font-medium">
                        Lihat Semua Buku
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Profile Card -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden card-hover">
                <div class="p-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-6">Profil Saya</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="text-sm text-gray-500">Nama Lengkap</label>
                            <p class="text-gray-900 font-medium">{{ auth()->user()->name }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-500">Email</label>
                            <p class="text-gray-900 font-medium">{{ auth()->user()->email }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-500">Status</label>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                Member Aktif
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Decorative blob -->
    <div class="fixed bottom-0 left-0 -z-10 opacity-10">
        <svg class="w-96 h-96 text-indigo-600" fill="currentColor" viewBox="0 0 200 200">
            <path d="M45,-77.2C58.3,-70.3,69,-58.2,77.2,-44.2C85.4,-30.2,91.1,-15.1,89.8,-0.7C88.6,13.6,80.4,27.3,71.5,40.1C62.6,53,53,65.1,40.3,73.3C27.6,81.5,13.8,85.8,0.4,85.2C-13,84.5,-26,78.9,-39.1,71.5C-52.2,64.1,-65.4,55,-73.7,42.1C-82,29.2,-85.4,14.6,-84.6,0.4C-83.8,-13.7,-78.9,-27.4,-70.6,-39.2C-62.2,-50.9,-50.5,-60.7,-37.6,-67.5C-24.7,-74.3,-12.4,-78.2,1.7,-81C15.8,-83.9,31.7,-84.1,45,-77.2Z" transform="translate(100 100)" />
        </svg>
    </div>
</body>
</html>
