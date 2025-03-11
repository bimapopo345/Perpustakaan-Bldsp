<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Perpustakaan Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .gradient-text {
            background: linear-gradient(to right, #4F46E5, #7C3AED);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .card-gradient {
            background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
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
    <nav class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <h1 class="text-2xl font-bold gradient-text">Admin Panel</h1>
                    </div>
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <a href="{{ route('admin.dashboard') }}" 
                           class="border-indigo-500 text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Dashboard
                        </a>
                        <a href="{{ route('admin.books.index') }}" 
                           class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Kelola Buku
                        </a>
                        <a href="{{ route('admin.members.index') }}"
                           class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Kelola Member
                        </a>
                        <a href="{{ route('admin.peminjaman.index') }}"
                           class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Kelola Peminjaman
                        </a>
                        <a href="{{ route('home') }}" 
                           class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Lihat Website
                        </a>
                    </div>
                </div>
                <div class="flex items-center">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 
                                       focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-300">
                            Logout
                            <svg class="ml-2 -mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Welcome Section -->
        <div class="px-4 py-6 sm:px-0">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden card-hover">
                <div class="card-gradient p-8">
                    <h2 class="text-3xl font-bold text-white mb-2">Selamat Datang di Panel Admin</h2>
                    <p class="text-indigo-100">Kelola konten perpustakaan digital dengan mudah dan efisien</p>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="mt-8 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <!-- Total Books Card -->
            <div class="bg-white overflow-hidden rounded-2xl shadow-xl card-hover">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 p-3 rounded-lg bg-indigo-500">
                            <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Buku</dt>
                                <dd class="text-3xl font-bold text-gray-900">{{ \App\Models\Book::count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-5 py-3">
                    <div class="text-sm">
                        <a href="{{ route('admin.books.index') }}" 
                           class="font-medium text-indigo-600 hover:text-indigo-500 inline-flex items-center">
                            Lihat semua buku
                            <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Total Members Card -->
            <div class="bg-white overflow-hidden rounded-2xl shadow-xl card-hover">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 p-3 rounded-lg bg-purple-500">
                            <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Member</dt>
                                <dd class="text-3xl font-bold text-gray-900">{{ \App\Models\User::where('role', 'member')->count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-5 py-3">
                    <div class="text-sm">
                        <a href="{{ route('admin.members.index') }}" 
                           class="font-medium text-purple-600 hover:text-purple-500 inline-flex items-center">
                            Lihat semua member
                            <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Total Peminjaman Card -->
            <div class="bg-white overflow-hidden rounded-2xl shadow-xl card-hover">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 p-3 rounded-lg bg-green-500">
                            <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Peminjaman</dt>
                                <dd class="text-3xl font-bold text-gray-900">{{ \App\Models\Peminjaman::count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-5 py-3">
                    <div class="text-sm">
                        <a href="{{ route('admin.peminjaman.index') }}" 
                           class="font-medium text-green-600 hover:text-green-500 inline-flex items-center">
                            Lihat semua peminjaman
                            <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Actions Card -->
            <div class="bg-white overflow-hidden rounded-2xl shadow-xl card-hover mt-5 sm:mt-0">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Aksi Cepat</h3>
                    <a href="{{ route('admin.books.create') }}" 
                       class="inline-flex items-center w-full px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 
                              text-white text-sm font-medium rounded-lg hover:from-indigo-700 hover:to-purple-700 
                              focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 
                              transition-all duration-300">
                        <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah Buku Baru
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Decorative Elements -->
    <div class="fixed top-0 right-0 -z-10 opacity-10">
        <svg class="w-96 h-96 text-indigo-600" fill="currentColor" viewBox="0 0 200 200">
            <path d="M45,-77.2C58.3,-70.3,69,-58.2,77.2,-44.2C85.4,-30.2,91.1,-15.1,89.8,-0.7C88.6,13.6,80.4,27.3,71.5,40.1C62.6,53,53,65.1,40.3,73.3C27.6,81.5,13.8,85.8,0.4,85.2C-13,84.5,-26,78.9,-39.1,71.5C-52.2,64.1,-65.4,55,-73.7,42.1C-82,29.2,-85.4,14.6,-84.6,0.4C-83.8,-13.7,-78.9,-27.4,-70.6,-39.2C-62.2,-50.9,-50.5,-60.7,-37.6,-67.5C-24.7,-74.3,-12.4,-78.2,1.7,-81C15.8,-83.9,31.7,-84.1,45,-77.2Z" transform="translate(100 100)" />
        </svg>
    </div>
</body>
</html>
