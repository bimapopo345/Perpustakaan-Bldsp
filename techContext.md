# Technical Context & Implementation Details

## Stack Teknologi

### Backend Framework

-   Laravel 12.0
    -   PHP 8.2+
    -   Composer untuk package management
    -   Laravel Queue untuk background jobs
    -   Laravel Cache untuk caching

### Database

-   MySQL 8.0+
    -   Indexing untuk optimasi query
    -   Foreign keys untuk integritas data
    -   Prepared statements untuk keamanan

### Frontend

-   Blade Template Engine
-   Tailwind CSS
-   JavaScript ES6+
    -   Fetch API untuk AJAX
    -   WebSocket untuk real-time updates

## Implementasi Chunking

### 1. Response Chunking

```php
public function index()
{
    return Book::query()
        ->when(request('search'), function($q, $search) {
            $q->where('judul', 'like', "%{$search}%");
        })
        ->chunk(100, function($books) {
            foreach ($books as $book) {
                // Process each chunk
            }
        });
}
```

### 2. PDF Streaming

```php
public function streamPdf($id)
{
    $book = Book::findOrFail($id);
    $path = storage_path("app/{$book->file_path}");

    return response()->stream(
        function() use ($path) {
            $stream = fopen($path, 'rb');
            while (!feof($stream)) {
                echo fread($stream, 1024 * 8); // 8KB chunks
                flush();
            }
            fclose($stream);
        },
        200,
        [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline'
        ]
    );
}
```

## Cache Implementation

### 1. Query Cache

```php
public function getBooks()
{
    return Cache::remember('books.all', 3600, function () {
        return Book::select(['id', 'judul', 'thumbnail_path'])
            ->latest()
            ->paginate(12);
    });
}
```

### 2. File Cache

```php
public function getPdfSegment($bookId, $segment)
{
    $cacheKey = "book.{$bookId}.segment.{$segment}";

    return Cache::remember($cacheKey, 3600, function () use ($bookId, $segment) {
        // Process and return PDF segment
        return $this->processPdfSegment($bookId, $segment);
    });
}
```

## Background Jobs

### 1. PDF Processing

```php
class ProcessPdfUpload implements ShouldQueue
{
    public function handle()
    {
        // 1. Validate PDF
        // 2. Generate thumbnails
        // 3. Split into segments
        // 4. Cache segments
    }
}
```

### 2. Notifications

```php
class SendPeminjamanNotification implements ShouldQueue
{
    public function handle()
    {
        // Batch notifications in chunks
        Notification::chunk(100, function($notifications) {
            // Process each notification chunk
        });
    }
}
```

## Security Measures

### 1. File Access

```php
public function generateSignedUrl($bookId)
{
    return URL::temporarySignedRoute(
        'books.view-pdf',
        now()->addMinutes(30),
        ['id' => $bookId]
    );
}
```

### 2. Rate Limiting

```php
// routes/web.php
Route::middleware(['auth', 'throttle:60,1'])->group(function () {
    Route::get('/book/{id}/pdf', 'BookController@viewPdf');
});
```

## Monitoring & Logging

### 1. Performance Logging

```php
Log::channel('performance')->info('Query Execution', [
    'query' => $query->toSql(),
    'time' => $executionTime,
    'memory' => memory_get_usage(true)
]);
```

### 2. Error Tracking

```php
try {
    // Process large dataset
} catch (\Exception $e) {
    Log::error('Data Processing Failed', [
        'error' => $e->getMessage(),
        'trace' => $e->getTraceAsString()
    ]);

    return response()->json([
        'error' => 'Processing failed',
        'code' => 'E_PROC_FAIL'
    ], 500);
}
```

## Development Guidelines

### Code Organization

-   Controllers: CRUD operations dan basic flow
-   Services: Business logic
-   Jobs: Background processing
-   Events/Listeners: Async operations
-   Resources: API transformations

### Performance Rules

1. Selalu gunakan pagination untuk list data
2. Cache queries yang sering diakses
3. Chunk large datasets
4. Implement lazy loading
5. Optimize database indexes

### Security Checklist

1. Input validation
2. Output sanitization
3. CSRF protection
4. Rate limiting
5. File access control
6. SQL injection prevention
