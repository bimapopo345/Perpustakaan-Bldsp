<div x-data="{ showModal: false, selectedBook: null }"
     @show-book.window="
        selectedBook = null;
        fetch(`/book/${$event.detail}`)
            .then(response => response.json())
            .then(data => {
                selectedBook = data;
                showModal = true;
            });">

    <div x-show="showModal" 
         class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4"
         x-cloak
         @keydown.escape.window="showModal = false">
        
        <div class="bg-white rounded-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto"
             @click.away="showModal = false">
            
            <!-- Modal Header -->
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 rounded-t-xl">
                <div class="flex items-center justify-between">
                    <h3 class="text-2xl font-bold text-gray-900" x-text="selectedBook?.judul"></h3>
                    <button @click="showModal = false" class="text-gray-400 hover:text-gray-500">
                        <span class="sr-only">Close</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="px-6 py-4">
                <div class="flex flex-col md:flex-row gap-8">
                    <!-- Thumbnail -->
                    <div class="md:w-1/2">
                        <template x-if="selectedBook?.thumbnail_path">
                            <img :src="selectedBook?.thumbnail_path" 
                                 class="w-full rounded-lg shadow-lg" 
                                 :alt="'Cover ' + selectedBook?.judul">
                        </template>
                        <template x-if="!selectedBook?.thumbnail_path">
                            <div class="w-full h-96 bg-gray-200 rounded-lg flex items-center justify-center">
                                <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                        </template>
                    </div>

                    <!-- Book Details -->
                    <div class="md:w-1/2">
                        <div class="prose max-w-none">
                            <div class="mb-6">
                                <h4 class="text-lg font-semibold text-gray-700">Tahun Terbit</h4>
                                <p class="text-gray-600" x-text="selectedBook?.tahun_terbit"></p>
                            </div>

                            <div>
                                <h4 class="text-lg font-semibold text-gray-700">Deskripsi</h4>
                                <p class="text-gray-600 whitespace-pre-line" x-text="selectedBook?.deskripsi"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 flex justify-end">
                    <a :href="selectedBook?.file_path" 
                       target="_blank"
                       class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        Baca Buku
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
