<div x-data="{ showModal: false, selectedBook: null }"
     x-init="
        window.addEventListener('book-selected', (event) => {
            fetch(`/book/${event.detail}`)
                .then(response => response.json())
                .then(data => {
                    selectedBook = data;
                    showModal = true;
                });
        });">

    <!-- Modal Backdrop -->
    <div x-show="showModal" 
         x-cloak
         class="fixed inset-0 z-50"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        <!-- Backdrop overlay -->
        <div class="fixed inset-0 bg-black/75 backdrop-blur-sm" @click="showModal = false"></div>

        <!-- Modal Panel -->
        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div x-show="showModal"
                     class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-4xl"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     @click.outside="showModal = false">

                    <!-- Close Button -->
                    <button @click="showModal = false" 
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
                                <template x-if="selectedBook?.thumbnail_path">
                                    <img :src="selectedBook.thumbnail_path" 
                                         :alt="'Cover ' + selectedBook?.judul"
                                         class="w-full h-[400px] object-cover">
                                </template>
                                <template x-if="!selectedBook?.thumbnail_path">
                                    <div class="w-full h-[400px] bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                                        <svg class="w-24 h-24 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        </svg>
                                    </div>
                                </template>
                            </div>

                            <!-- Book Details -->
                            <div class="md:w-1/2 p-8">
                                <h3 class="text-2xl font-bold text-gray-900 mb-4" x-text="selectedBook?.judul"></h3>
                                <p class="text-gray-600 mb-6">
                                    <span class="font-semibold">Tahun Terbit:</span>
                                    <span x-text="selectedBook?.tahun_terbit"></span>
                                </p>
                                <div class="prose max-w-none mb-8">
                                    <h4 class="text-lg font-semibold text-gray-900 mb-2">Deskripsi</h4>
                                    <p class="text-gray-600" x-text="selectedBook?.deskripsi"></p>
                                </div>
                                <a :href="selectedBook?.read_url"
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
