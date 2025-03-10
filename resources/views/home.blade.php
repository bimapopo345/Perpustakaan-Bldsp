<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100" x-data="{ showModal: false, selectedBook: null }">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <span class="text-xl font-semibold">Perpustakaan Digital</span>
                </div>
            </div>
        </div>
    </nav>

    <!-- Search Section -->
    <div class="max-w-7xl mx-auto px-4 py-6">
        <form action="{{ route('home') }}" method="GET" class="flex gap-4">
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="Cari judul buku..."
                   class="flex-1 rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
            <button type="submit" 
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Cari
            </button>
        </form>
    </div>

    <!-- Books Grid -->
    <div class="max-w-7xl mx-auto px-4 py-6">
        @if($books->isEmpty())
            <div class="text-center py-12">
                <p class="text-gray-500 text-lg">Tidak ada buku yang ditemukan.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($books as $book)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 cursor-pointer"
                         @click="selectedBook = null; 
                                fetch('{{ route('book.show', $book) }}')
                                    .then(response => response.json())
                                    .then(data => {
                                        selectedBook = data;
                                        showModal = true;
                                    });">
                        @if($book->thumbnail_path)
                            <div class="aspect-w-3 aspect-h-4">
                                <img src="{{ asset('storage/' . $book->thumbnail_path) }}" 
                                     alt="Thumbnail {{ $book->judul }}"
                                     class="w-full h-48 object-cover">
                            </div>
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                        @endif
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $book->judul }}</h3>
                            <p class="text-sm text-gray-600 mb-2">Tahun: {{ $book->tahun_terbit }}</p>
                            <p class="text-sm text-gray-500">{{ Str::limit($book->deskripsi, 100) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $books->links() }}
            </div>
        @endif
    </div>

    <!-- Modal -->
    <div x-show="showModal" 
         class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4"
         x-cloak>
            <div class="bg-white rounded-lg max-w-3xl w-full max-h-[90vh] overflow-y-auto"
             @click.away="showModal = false">
            <div class="p-6">
                <div class="flex justify-between items-start mb-4">
                    <h2 class="text-2xl font-bold text-gray-800" x-text="selectedBook?.judul"></h2>
                    <button @click="showModal = false" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <div class="space-y-4">
                    <div class="flex flex-col md:flex-row gap-6">
                        <div class="w-full md:w-1/3">
                            <template x-if="selectedBook?.thumbnail_path">
                                <img :src="selectedBook?.thumbnail_path" 
                                     class="w-full rounded-lg shadow-md" 
                                     :alt="'Thumbnail ' + selectedBook?.judul">
                            </template>
                            <template x-if="!selectedBook?.thumbnail_path">
                                <div class="w-full h-48 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                            </template>
                        </div>
                        <div class="flex-1">
                            <p class="text-gray-600 mb-4">
                                <span class="font-semibold">Tahun Terbit:</span>
                                <span x-text="selectedBook?.tahun_terbit"></span>
                            </p>
                            
                            <div>
                                <h3 class="font-semibold text-gray-700 mb-2">Deskripsi:</h3>
                                <p class="text-gray-600" x-text="selectedBook?.deskripsi"></p>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end pt-6">
                        <a :href="selectedBook?.file_path" 
                           target="_blank"
                           class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Baca Buku
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alpine.js Styles -->
    <style>
        [x-cloak] { display: none !important; }
    </style>
</body>
</html>
