<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <span class="text-xl font-bold text-gray-800">Admin Panel</span>
                    </div>
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <a href="{{ route('admin.dashboard') }}" 
                           class="border-transparent text-gray-500 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Dashboard
                        </a>
                        <a href="{{ route('admin.books.index') }}" 
                           class="border-blue-500 text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
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
        <div class="md:flex md:items-center md:justify-between mb-6">
            <div class="flex-1 min-w-0">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    Tambah Buku Baru
                </h2>
            </div>
            <div class="mt-4 flex md:mt-0 md:ml-4">
                <a href="{{ route('admin.books.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Kembali
                </a>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data" class="divide-y divide-gray-200">
                @csrf
                <div class="px-4 py-5 sm:p-6">
                    <!-- Validation Errors -->
                    @if ($errors->any())
                        <div class="rounded-md bg-red-50 p-4 mb-6">
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

                    <!-- Form Fields -->
                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        <div class="sm:col-span-6">
                            <label for="judul" class="block text-sm font-medium text-gray-700">
                                Judul Buku
                            </label>
                            <div class="mt-1">
                                <input type="text" name="judul" id="judul" 
                                       class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                       value="{{ old('judul') }}" required>
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="thumbnail" class="block text-sm font-medium text-gray-700">
                                Thumbnail Buku
                            </label>
                            <div class="mt-1">
                                <input type="file" name="thumbnail" id="thumbnail"
                                       class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300"
                                       accept="image/*" required>
                            </div>
                            <p class="mt-2 text-sm text-gray-500">
                                Gambar JPG/PNG dengan ukuran maksimal 2MB
                            </p>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="file" class="block text-sm font-medium text-gray-700">
                                File PDF
                            </label>
                            <div class="mt-1">
                                <input type="file" name="file" id="file"
                                       class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300"
                                       accept=".pdf" required>
                            </div>
                            <p class="mt-2 text-sm text-gray-500">
                                File PDF dengan ukuran maksimal 10MB
                            </p>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="tahun_terbit" class="block text-sm font-medium text-gray-700">
                                Tahun Terbit
                            </label>
                            <div class="mt-1">
                                <input type="number" name="tahun_terbit" id="tahun_terbit" 
                                       class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                       min="1900" max="{{ date('Y') }}"
                                       value="{{ old('tahun_terbit') }}" required>
                            </div>
                        </div>

                        <div class="sm:col-span-6">
                            <label for="deskripsi" class="block text-sm font-medium text-gray-700">
                                Deskripsi
                            </label>
                            <div class="mt-1">
                                <textarea id="deskripsi" name="deskripsi" rows="4"
                                          class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                          required>{{ old('deskripsi') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <button type="submit"
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Simpan Buku
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
