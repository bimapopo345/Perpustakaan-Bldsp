<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .gradient-text {
            background: linear-gradient(to right, #4F46E5, #7C3AED);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .gradient-border:focus {
            border-color: transparent;
            background-image: linear-gradient(white, white), linear-gradient(to right, #4F46E5, #7C3AED);
            background-origin: border-box;
            background-clip: padding-box, border-box;
        }
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-slideIn {
            animation: slideIn 0.5s ease-out forwards;
        }
    </style>
</head>
<body class="bg-gray-50" x-data="{ 
    previewUrl: null,
    abstrakPreviewUrl: null,
    abstrakType: 'text',
    handleThumbnailChange(event) {
        const file = event.target.files[0];
        if (file) {
            this.previewUrl = URL.createObjectURL(file);
        }
    },
    handleAbstrakImageChange(event) {
        const file = event.target.files[0];
        if (file) {
            this.abstrakPreviewUrl = URL.createObjectURL(file);
        }
    }
}">
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
                           class="border-transparent text-gray-500 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Dashboard
                        </a>
                        <a href="{{ route('admin.books.index') }}" 
                           class="border-indigo-500 text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Kelola Buku
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="md:flex md:items-center md:justify-between mb-6 animate-slideIn">
            <div class="flex-1 min-w-0">
                <h2 class="text-3xl font-bold leading-7 text-gray-900 sm:truncate">
                    Tambah Buku Baru
                </h2>
                <p class="mt-2 text-sm text-gray-500">
                    Isi form berikut untuk menambahkan buku baru ke perpustakaan digital.
                </p>
            </div>
            <div class="mt-4 flex md:mt-0 md:ml-4">
                <a href="{{ route('admin.books.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium 
                          text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 
                          focus:ring-indigo-500 transition-all duration-300">
                    <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden animate-slideIn" style="animation-delay: 0.1s">
            <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data" class="divide-y divide-gray-200">
                @csrf
                <div class="px-8 py-8">
                    <!-- Validation Errors -->
                    @if ($errors->any())
                        <div class="rounded-lg bg-red-50 p-4 mb-6">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">
                                        Terdapat {{ $errors->count() }} kesalahan pada form:
                                    </h3>
                                    <div class="mt-2 text-sm text-red-700">
                                        <ul class="list-disc pl-5 space-y-1">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Form Grid -->
                    <div class="grid grid-cols-1 gap-y-8 gap-x-4 sm:grid-cols-6">
                        <div class="sm:col-span-4">
                            <label for="judul" class="block text-sm font-semibold text-gray-700 mb-2">
                                Judul Buku
                            </label>
                            <div class="mt-1">
                                <input type="text" name="judul" id="judul" 
                                       class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 
                                              focus:border-transparent transition-all duration-300 py-3 px-4"
                                       placeholder="Masukkan judul buku"
                                       value="{{ old('judul') }}" required>
                            </div>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="kategori" class="block text-sm font-semibold text-gray-700 mb-2">
                                Kategori
                            </label>
                            <div class="mt-1">
                                <select name="kategori" id="kategori"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 
                                           focus:border-transparent transition-all duration-300 py-3 px-4">
                                    @foreach ($kategoriOptions as $value => $label)
                                        <option value="{{ $value }}" {{ old('kategori') == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="sm:col-span-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Abstrak
                            </label>
                            <div class="mt-1 space-y-4">
                                <div class="flex space-x-4 mb-4">
                                    <button type="button" @click="abstrakType = 'text'"
                                            :class="{'bg-indigo-600 text-white': abstrakType === 'text', 'bg-white text-gray-700': abstrakType !== 'text'}"
                                            class="px-4 py-2 rounded-lg border border-gray-300 text-sm font-medium transition-all duration-300">
                                        Text
                                    </button>
                                    <button type="button" @click="abstrakType = 'image'"
                                            :class="{'bg-indigo-600 text-white': abstrakType === 'image', 'bg-white text-gray-700': abstrakType !== 'image'}"
                                            class="px-4 py-2 rounded-lg border border-gray-300 text-sm font-medium transition-all duration-300">
                                        Image
                                    </button>
                                </div>

                                <div x-show="abstrakType === 'text'">
                                    <textarea name="abstrak_text" rows="4"
                                              class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 
                                                     focus:border-transparent transition-all duration-300 py-3 px-4"
                                              placeholder="Masukkan abstrak buku dalam bentuk text">{{ old('abstrak_text') }}</textarea>
                                    <p class="mt-2 text-sm text-gray-500">Maksimal 1000 kata</p>
                                </div>

                                <div x-show="abstrakType === 'image'" class="mt-1">
                                    <div class="flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-indigo-500 transition-colors duration-300">
                                        <div class="space-y-1 text-center">
                                            <template x-if="!abstrakPreviewUrl">
                                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                            </template>
                                            <template x-if="abstrakPreviewUrl">
                                                <img :src="abstrakPreviewUrl" class="mx-auto h-32 w-auto object-cover rounded-lg">
                                            </template>
                                            <div class="flex text-sm text-gray-600 mt-4">
                                                <label for="abstrak_image" class="relative cursor-pointer rounded-md font-medium text-indigo-600 hover:text-indigo-500">
                                                    <span>Upload gambar abstrak</span>
                                                    <input id="abstrak_image" name="abstrak_image" type="file" accept="image/*" class="sr-only"
                                                           @change="handleAbstrakImageChange">
                                                </label>
                                            </div>
                                            <p class="text-xs text-gray-500 mt-2">
                                                PNG, JPG hingga 2MB
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="thumbnail" class="block text-sm font-semibold text-gray-700 mb-2">
                                Thumbnail Buku
                            </label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-indigo-500 transition-colors duration-300">
                                <div class="space-y-1 text-center">
                                    <template x-if="!previewUrl">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </template>
                                    <template x-if="previewUrl">
                                        <img :src="previewUrl" class="mx-auto h-32 w-auto object-cover rounded-lg">
                                    </template>
                                    <div class="flex text-sm text-gray-600 mt-4">
                                        <label for="thumbnail" class="relative cursor-pointer rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                            <span>Upload thumbnail</span>
                                            <input id="thumbnail" name="thumbnail" type="file" accept="image/*" class="sr-only"
                                                   @change="handleThumbnailChange" required>
                                        </label>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-2">
                                        PNG, JPG hingga 2MB
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="file" class="block text-sm font-semibold text-gray-700 mb-2">
                                File PDF
                            </label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-indigo-500 transition-colors duration-300">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <div class="flex text-sm text-gray-600 mt-4">
                                        <label for="file" class="relative cursor-pointer rounded-md font-medium text-indigo-600 hover:text-indigo-500">
                                            <span>Upload PDF</span>
                                            <input id="file" name="file" type="file" accept=".pdf" class="sr-only" required>
                                        </label>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-2">
                                        PDF hingga 10MB
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="tahun_terbit" class="block text-sm font-semibold text-gray-700 mb-2">
                                Tahun Terbit
                            </label>
                            <div class="mt-1">
                                <input type="number" name="tahun_terbit" id="tahun_terbit" 
                                       class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 
                                              focus:border-transparent transition-all duration-300 py-3 px-4"
                                       min="1900" max="{{ date('Y') }}"
                                       value="{{ old('tahun_terbit') }}" required>
                            </div>
                        </div>

                        <div class="sm:col-span-6">
                            <label for="deskripsi" class="block text-sm font-semibold text-gray-700 mb-2">
                                Deskripsi
                            </label>
                            <div class="mt-1">
                                <textarea id="deskripsi" name="deskripsi" rows="4"
                                          class="block w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 
                                                 focus:border-transparent transition-all duration-300 py-3 px-4"
                                          placeholder="Masukkan deskripsi buku"
                                          required>{{ old('deskripsi') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="px-8 py-5 bg-gray-50">
                    <button type="submit"
                            class="w-full sm:w-auto inline-flex justify-center py-3 px-8 border border-transparent shadow-sm text-sm font-medium 
                                   rounded-lg text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 
                                   hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 
                                   transition-all duration-300 transform hover:scale-105">
                        Simpan Buku
                    </button>
                </div>
            </form>
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
