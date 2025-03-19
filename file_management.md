# Manajemen File

## Struktur Penyimpanan

### Direktori Storage

```
storage/
  app/
    public/
      thumbnails/  # Thumbnail buku
      pdfs/        # File PDF buku
```

### Public Symlink

File publik diakses melalui symbolic link:

```bash
public/storage -> storage/app/public
```

## Upload File

### Thumbnail Upload

File: `app/Http/Controllers/Admin/BookController.php`

```php
// Validasi
$request->validate([
    'thumbnail' => 'required|image|mimes:jpeg,png,jpg|max:2048'
]);

// Upload
$thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
```

Spesifikasi:

-   Max size: 2MB
-   Format: jpeg, png, jpg
-   Disimpan di: storage/app/public/thumbnails
-   Nama file: auto-generated unique name

### PDF Upload

```php
// Validasi
$request->validate([
    'file' => 'required|mimes:pdf|max:10240'
]);

// Upload
$pdfPath = $request->file('file')->store('pdfs', 'public');
```

Spesifikasi:

-   Max size: 10MB
-   Format: PDF only
-   Disimpan di: storage/app/public/pdfs
-   Nama file: auto-generated unique name

## Pengambilan File

### URL Generation

File: `app/Models/Book.php`

```php
// Thumbnail URL
public function getThumbnailUrlAttribute()
{
    if (!$this->thumbnail_path) {
        return null;
    }
    return asset('storage/' . $this->thumbnail_path);
}

// PDF URL
public function getPdfUrlAttribute()
{
    if (!$this->file_path) {
        return null;
    }
    return asset('storage/' . $this->file_path);
}
```

### File Download/View

File: `app/Http/Controllers/BookController.php`

```php
// View PDF
public function viewPdf($id)
{
    $book = Book::findOrFail($id);
    return response()->file(storage_path('app/public/' . $book->file_path));
}
```

## Penghapusan File

### Delete dengan Model

File: `app/Http/Controllers/Admin/BookController.php`

```php
public function destroy(Book $book)
{
    // Hapus thumbnail
    if ($book->thumbnail_path) {
        Storage::disk('public')->delete($book->thumbnail_path);
    }

    // Hapus PDF
    if ($book->file_path) {
        Storage::disk('public')->delete($book->file_path);
    }

    // Hapus record
    $book->delete();
}
```

### Update File

```php
public function update(Request $request, Book $book)
{
    // Jika ada thumbnail baru
    if ($request->hasFile('thumbnail')) {
        // Hapus thumbnail lama
        if ($book->thumbnail_path) {
            Storage::disk('public')->delete($book->thumbnail_path);
        }
        // Upload thumbnail baru
        $data['thumbnail_path'] = $request->file('thumbnail')
            ->store('thumbnails', 'public');
    }

    // Jika ada PDF baru
    if ($request->hasFile('file')) {
        // Hapus PDF lama
        if ($book->file_path) {
            Storage::disk('public')->delete($book->file_path);
        }
        // Upload PDF baru
        $data['file_path'] = $request->file('file')
            ->store('pdfs', 'public');
    }
}
```

## Validasi File

### Client-side Validation

```html
<input type="file" accept="image/jpeg,image/png,image/jpg" max="2048000" />

<input type="file" accept="application/pdf" max="10240000" />
```

### Server-side Validation

```php
$request->validate([
    'thumbnail' => [
        'required',
        'image',
        'mimes:jpeg,png,jpg',
        'max:2048',
        function ($attribute, $value, $fail) {
            // Custom validation
            $image = Image::make($value);
            if ($image->width() < 100 || $image->height() < 100) {
                $fail('The image must be at least 100x100 pixels.');
            }
        },
    ],
    'file' => [
        'required',
        'mimes:pdf',
        'max:10240',
    ],
]);
```

## Keamanan File

### Access Control

```php
// Middleware untuk akses file
public function handle($request, Closure $next)
{
    $book = Book::findOrFail($request->route('id'));

    if (!auth()->user()->canAccess($book)) {
        abort(403);
    }

    return $next($request);
}
```

### File Permission

```
chmod -R 775 storage/app/public/thumbnails
chmod -R 775 storage/app/public/pdfs
```

### Disk Configuration

File: `config/filesystems.php`

```php
'disks' => [
    'public' => [
        'driver' => 'local',
        'root' => storage_path('app/public'),
        'url' => env('APP_URL').'/storage',
        'visibility' => 'public',
        'throw' => false,
    ],
],
```

## Error Handling

### Upload Errors

```php
try {
    $path = $request->file('thumbnail')->store('thumbnails', 'public');
} catch (\Exception $e) {
    return back()->with('error', 'Gagal upload file.');
}
```

### File Not Found

```php
if (!Storage::disk('public')->exists($book->file_path)) {
    abort(404, 'File tidak ditemukan.');
}
```

## Clean Up

### Temporary Files

```php
// Hapus file temporary setelah upload
if ($request->hasFile('thumbnail')) {
    $file = $request->file('thumbnail');
    unlink($file->getPathname());
}
```

### Orphaned Files

```php
// Schedule untuk membersihkan file yang tidak terpakai
$schedule->command('cleanup:orphaned-files')->daily();
```

## Best Practices

1. File Naming

```php
$filename = time() . '_' . uniqid() . '.' . $file->extension();
```

2. Chunked Upload

```php
// Untuk file besar
$disk = Storage::disk('public');
$chunk = $request->file('chunk');
$disk->append($path, $chunk->get());
```

3. Error Logging

```php
Log::error('File upload error: ' . $e->getMessage(), [
    'file' => $request->file('file')->getClientOriginalName(),
    'user' => auth()->id(),
]);
```
