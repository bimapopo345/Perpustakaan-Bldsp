# Views dan UI Components

## Layout Utama

File: `resources/views/layouts/app.blade.php`

Layout utama yang digunakan di seluruh aplikasi, menggunakan Tailwind CSS untuk styling.

```blade
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Perpustakaan') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <nav><!-- Navigation bar --></nav>
    <main>@yield('content')</main>
    <footer><!-- Footer content --></footer>
</body>
</html>
```

## Struktur Views

### Public Views

#### Home Page

File: `resources/views/home.blade.php`

-   Grid display buku-buku
-   Thumbnail dan info dasar buku
-   Pagination

#### Book Detail

File: `resources/views/books/read.blade.php`

-   Informasi detail buku
-   Preview PDF
-   Tombol peminjaman (untuk member)

### Member Area

#### Member Dashboard

File: `resources/views/member/dashboard.blade.php`

-   Overview aktivitas
-   Link ke menu peminjaman

#### Peminjaman

1. `resources/views/peminjaman/create.blade.php`

    - Form peminjaman buku
    - Preview buku yang akan dipinjam
    - Input tanggal dan durasi

2. `resources/views/peminjaman/index.blade.php`
    - Tabel riwayat peminjaman
    - Status dengan warna berbeda
    - Filter dan pagination

### Admin Area

#### Admin Dashboard

File: `resources/views/admin/dashboard.blade.php`

-   Overview statistik
-   Quick links ke manajemen

#### Book Management

1. `resources/views/admin/books/index.blade.php`

    - Tabel daftar buku
    - Aksi CRUD
    - Search dan filter

2. `resources/views/admin/books/create.blade.php`

    - Form tambah buku
    - Upload thumbnail dan PDF
    - Validasi client-side

3. `resources/views/admin/books/edit.blade.php`
    - Form edit buku
    - Preview file existing
    - Opsi update file

#### Member Management

File: `resources/views/admin/members/index.blade.php`

-   Tabel daftar member
-   Filter dan search
-   Status aktivitas

#### Peminjaman Management

File: `resources/views/admin/peminjaman/index.blade.php`

-   Tabel semua peminjaman
-   Filter status
-   Aksi approve/reject/return

### Authentication Views

#### Login

File: `resources/views/auth/login.blade.php`

```blade
@extends('layouts.app')

@section('content')
<div class="container">
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <!-- Email field -->
        <!-- Password field -->
        <!-- Remember me -->
        <!-- Submit button -->
    </form>
</div>
@endsection
```

#### Register

File: `resources/views/auth/register.blade.php`

```blade
@extends('layouts.app')

@section('content')
<div class="container">
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <!-- Name field -->
        <!-- Email field -->
        <!-- Password fields -->
        <!-- Submit button -->
    </form>
</div>
@endsection
```

## Components

### Book Modal

File: `resources/views/partials/book-modal.blade.php`

-   Modal detail buku
-   Dynamic content loading
-   Responsive design

## Styling

### Tailwind Classes

1. Container & Layout:

```css
.container mx-auto px-4 py-8 .max-w-2xl mx-auto .bg-white rounded-lg shadow-md;
```

2. Forms:

```css
.form-input mt-1 block w-full
.rounded-md border-gray-300
.focus:border-blue-500 focus:ring-blue-500
```

3. Buttons:

```css
.inline-flex justify-center
.rounded-md border border-transparent
.bg-blue-600 text-white
.hover:bg-blue-700
```

4. Tables:

```css
.min-w-full
    divide-y
    divide-gray-200
    .px-6
    py-3
    text-left
    text-xs
    font-medium
    .whitespace-nowrap
    text-sm
    text-gray-500;
```

5. Status Colors:

```css
.bg-yellow-100 text-yellow-800  /* menunggu */
.bg-blue-100 text-blue-800      /* disetujui */
.bg-green-100 text-green-800    /* dipinjam */
.bg-gray-100 text-gray-800      /* dikembalikan */
.bg-red-100 text-red-800; /* ditolak/terlambat */
```

## JavaScript Components

### File Upload Preview

```javascript
function previewImage(input, preview) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
```

### Dynamic Modal

```javascript
function openModal(bookId) {
    fetch(`/book/${bookId}`)
        .then((response) => response.text())
        .then((html) => {
            document.getElementById("modal-content").innerHTML = html;
            document.getElementById("book-modal").classList.remove("hidden");
        });
}
```

## Error Handling

### Validation Errors

```blade
@error('field_name')
    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
@enderror
```

### Flash Messages

```blade
@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
        {{ session('success') }}
    </div>
@endif
```

## Responsive Design

### Breakpoints

-   sm: 640px
-   md: 768px
-   lg: 1024px
-   xl: 1280px
-   2xl: 1536px

### Example Responsive Grid

```html
<div
    class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4"
>
    <!-- Content -->
</div>
```
