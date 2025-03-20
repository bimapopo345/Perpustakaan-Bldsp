# Konfigurasi Teknis Sistem

## Environment Setup

### Requirement Sistem

-   PHP >= 8.2
-   Composer
-   Node.js & NPM
-   SQLite / MySQL
-   Extension PHP yang diperlukan:
    -   PDO SQLite
    -   BCMath
    -   Ctype
    -   Fileinfo
    -   JSON
    -   Mbstring
    -   OpenSSL
    -   PDO
    -   Tokenizer
    -   XML

### Instalasi Development

```bash
# Clone repository
git clone [repository-url]

# Install PHP dependencies
composer install

# Install NPM packages
npm install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Link storage
php artisan storage:link

# Run migrations
php artisan migrate

# Seed database
php artisan db:seed

# Build assets
npm run build
```

## Dependencies

### 1. PHP Dependencies (composer.json)

```json
{
    "require": {
        "php": "^8.2",
        "laravel/framework": "^12.0",
        "laravel/sanctum": "^4.0",
        "laravel/tinker": "^2.9"
    },
    "require-dev": {
        "fakerphp/faker": "^1.23",
        "laravel/pint": "^1.13",
        "laravel/sail": "^1.26",
        "mockery/mockery": "^1.6",
        "nunomaduro/collision": "^8.1",
        "phpunit/phpunit": "^10.5",
        "spatie/laravel-ignition": "^2.4"
    }
}
```

### 2. JavaScript Dependencies (package.json)

```json
{
    "dependencies": {
        "tailwindcss": "^3.4.1",
        "@tailwindcss/forms": "^0.5.7"
    },
    "devDependencies": {
        "autoprefixer": "^10.4.17",
        "axios": "^1.6.4",
        "laravel-vite-plugin": "^1.0.0",
        "postcss": "^8.4.35",
        "vite": "^5.0.0"
    }
}
```

## File Storage Configuration

### 1. Disk Configuration (config/filesystems.php)

```php
'disks' => [
    'local' => [
        'driver' => 'local',
        'root' => storage_path('app'),
        'throw' => false,
    ],
    'public' => [
        'driver' => 'local',
        'root' => storage_path('app/public'),
        'url' => env('APP_URL').'/storage',
        'visibility' => 'public',
        'throw' => false,
    ]
]
```

### 2. File Upload Structure

```
storage/
├── app/
│   ├── public/
│   │   ├── thumbnails/    # Thumbnail buku
│   │   └── pdfs/         # File PDF buku
│   └── private/          # File sistem
└── logs/                 # Log aplikasi
```

### 3. File Permission

```bash
# Storage permission
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/

# User permission
chown -R www-data:www-data storage/
chown -R www-data:www-data bootstrap/cache/
```

## Queue System

### 1. Queue Configuration (config/queue.php)

```php
'default' => env('QUEUE_CONNECTION', 'database'),

'connections' => [
    'database' => [
        'driver' => 'database',
        'table' => 'jobs',
        'queue' => 'default',
        'retry_after' => 90,
        'after_commit' => false,
    ],
]
```

### 2. Job Processing

```bash
# Start queue worker
php artisan queue:work --queue=default

# Monitoring queue
php artisan queue:monitor
```

### 3. Failed Jobs

```php
'failed' => [
    'driver' => env('QUEUE_FAILED_DRIVER', 'database-uuids'),
    'database' => env('DB_CONNECTION', 'sqlite'),
    'table' => 'failed_jobs',
]
```

## Cache Configuration

### 1. Cache Driver (config/cache.php)

```php
'default' => env('CACHE_DRIVER', 'database'),

'stores' => [
    'database' => [
        'driver' => 'database',
        'table' => 'cache',
        'connection' => null,
        'lock_connection' => null,
    ],
]
```

### 2. Cache Keys

```php
// Prefix cache key
'prefix' => env('CACHE_PREFIX', 'perpus_cache'),

// Cache TTL default (dalam detik)
'ttl' => 3600, // 1 jam
```

### 3. Cache Tags

```php
// Book cache tags
'books' => [
    'list',
    'detail',
    'search'
],

// Peminjaman cache tags
'peminjaman' => [
    'user',
    'admin',
    'status'
]
```

## Session Configuration

### 1. Session Driver (config/session.php)

```php
'driver' => env('SESSION_DRIVER', 'database'),

'lifetime' => env('SESSION_LIFETIME', 120), // dalam menit

'table' => 'sessions'
```

### 2. Session Security

```php
'secure' => env('SESSION_SECURE_COOKIE'),
'same_site' => 'lax',
'http_only' => true
```

## Mail Configuration

### 1. Mail Driver (config/mail.php)

```php
'default' => env('MAIL_MAILER', 'smtp'),

'mailers' => [
    'smtp' => [
        'transport' => 'smtp',
        'host' => env('MAIL_HOST', 'smtp.mailgun.org'),
        'port' => env('MAIL_PORT', 587),
        'encryption' => env('MAIL_ENCRYPTION', 'tls'),
    ],
]
```

### 2. Mail Queue

```php
'queue' => [
    'enabled' => true,
    'queue' => 'emails'
]
```

## Environment Variables

### 1. Application

```env
APP_NAME=Perpustakaan
APP_ENV=local
APP_KEY=base64:xxx
APP_DEBUG=true
APP_URL=http://localhost
```

### 2. Database

```env
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

### 3. File System

```env
FILESYSTEM_DISK=local
```

### 4. Queue

```env
QUEUE_CONNECTION=database
```

### 5. Cache

```env
CACHE_DRIVER=database
```

### 6. Session

```env
SESSION_DRIVER=database
SESSION_LIFETIME=120
```

## Development Tools

### 1. Vite Configuration (vite.config.js)

```javascript
export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
    ],
});
```

### 2. Tailwind Configuration (tailwind.config.js)

```javascript
export default {
    content: ["./resources/**/*.blade.php", "./resources/**/*.js"],
    theme: {
        extend: {},
    },
    plugins: [require("@tailwindcss/forms")],
};
```

### 3. PostCSS Configuration (postcss.config.js)

```javascript
export default {
    plugins: {
        tailwindcss: {},
        autoprefixer: {},
    },
};
```

## Monitoring & Logging

### 1. Log Configuration (config/logging.php)

```php
'default' => env('LOG_CHANNEL', 'daily'),

'channels' => [
    'daily' => [
        'driver' => 'daily',
        'path' => storage_path('logs/laravel.log'),
        'level' => env('LOG_LEVEL', 'debug'),
        'days' => 14,
    ],
]
```

### 2. Log Format

```
[YYYY-MM-DD HH:mm:ss] production.LEVEL: Message
Context: {
    "url": "/path",
    "method": "GET",
    "ip": "127.0.0.1",
    "user_id": 1
}
```

## Security Configuration

### 1. CORS (config/cors.php)

```php
return [
    'paths' => ['api/*'],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['*'],
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false,
];
```

### 2. Headers Security

```php
// CSP Headers
header("Content-Security-Policy: default-src 'self'");
header("X-Frame-Options: SAMEORIGIN");
header("X-XSS-Protection: 1; mode=block");
header("X-Content-Type-Options: nosniff");
```
