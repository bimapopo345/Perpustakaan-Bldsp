<div id="bookModal" class="hidden">
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.querySelector('#bookModal');
            const thumbnail = document.querySelector('#bookThumbnail');
            const noThumbnail = document.querySelector('#noThumbnail');
            
            window.addEventListener('book-selected', function(event) {
                fetch('/book/' + event.detail)
                    .then(response => response.json())
                    .then(data => {
                        modal.classList.remove('hidden');
                        document.querySelector('#bookTitle').textContent = data.judul;
                        document.querySelector('#bookYear').textContent = data.tahun_terbit;
                        document.querySelector('#bookDescription').textContent = data.deskripsi;
                        document.querySelector('#readBookBtn').href = data.read_url;
                        document.querySelector('.book-id').value = data.id;
                        
                        if (data.thumbnail_path) {
                            thumbnail.src = data.thumbnail_path;
                            thumbnail.classList.remove('hidden');
                            noThumbnail.classList.add('hidden');
                        } else {
                            thumbnail.classList.add('hidden');
                            noThumbnail.classList.remove('hidden');
                        }
                    });
            });

            function closeModal() {
                modal.classList.add('hidden');
            }

            document.querySelector('#closeModal').addEventListener('click', closeModal);
            document.querySelector('#modalBackdrop').addEventListener('click', closeModal);
        });
    </script>

    <!-- Modal Backdrop -->
    <div class="fixed inset-0 z-50 bg-black/75 backdrop-blur-sm ease-out duration-300">
        <!-- Backdrop overlay -->
        <div class="fixed inset-0 bg-black/75 backdrop-blur-sm" id="modalBackdrop"></div>

        <!-- Modal Panel -->
        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div
                     class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-4xl ease-out duration-300">

                    <!-- Close Button -->
                    <button id="closeModal"
                            class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 z-10">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>

                    <!-- Content -->
                    <div class="relative">
                        <div class="flex flex-col md:flex-row">
                            <!-- Thumbnail -->
                            <div class="md:w-1/2 relative">
                                <img id="bookThumbnail" class="w-full h-[400px] object-cover">
                                <div id="noThumbnail" class="hidden">
                                    <div class="w-full h-[400px] bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                                        <svg class="w-24 h-24 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Book Details -->
                            <div class="md:w-1/2 p-8">
                                <h3 id="bookTitle" class="text-2xl font-bold text-gray-900 mb-4"></h3>
                                <p class="text-gray-600 mb-6">
                                    <span class="font-semibold">Tahun Terbit:</span>
                                    <span id="bookYear"></span>
                                </p>
                                <div class="prose max-w-none mb-8">
                                    <h4 class="text-lg font-semibold text-gray-900 mb-2">Deskripsi</h4>
                                    <p id="bookDescription" class="text-gray-600"></p>
                                </div>
                                <div class="space-y-4">
                                    <a id="readBookBtn" href="#"
                                       class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium 
                                              rounded-xl text-white bg-gradient-to-r from-indigo-600 to-purple-600 
                                              hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 
                                              focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300 
                                              transform hover:scale-105 shadow-lg">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        </svg>
                                        Baca Buku
                                    </a>

                                    @auth
                                        @if(auth()->user()->role === 'member')
                                            <form method="POST" action="{{ route('peminjaman.store') }}" class="inline borrow-form">
                                                @csrf
                                                <input type="hidden" name="book_id" class="book-id">
                                                <input type="hidden" name="tanggal_pinjam" value="{{ date('Y-m-d') }}">
                                                <input type="hidden" name="durasi" value="1">
                                                <button type="submit"
                                                        class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium 
                                                      rounded-xl text-white bg-gradient-to-r from-green-600 to-teal-600 
                                                      hover:from-green-700 hover:to-teal-700 focus:outline-none focus:ring-2 
                                                      focus:ring-offset-2 focus:ring-green-500 transition-all duration-300 
                                                      transform hover:scale-105 shadow-lg">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                          d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                Pinjam Buku
                                                </button>
                                            </form>
                                        @endif
                                    @else
                                        <a href="{{ route('login') }}"
                                           class="inline-flex items-center px-6 py-3 border border-gray-300 text-base font-medium 
                                                  rounded-xl text-gray-700 bg-white hover:bg-gray-50 focus:outline-none 
                                                  focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all 
                                                  duration-300 transform hover:scale-105 shadow-lg">
                                            Login untuk Meminjam
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
