# Konteks Teknis Proyek

## Tech Stack

### Backend

-   **Framework**: Laravel 12
-   **PHP Version**: 8.2
-   **Database**: SQLite
-   **File Storage**: Local disk dengan symlink ke public

### Frontend

-   **CSS Framework**: Tailwind CSS 3.4
-   **Build Tool**: Vite 6.0
-   **JavaScript**: ES Modules
-   **HTTP Client**: Axios 1.7

## Development Tools

### Package Manager

-   **PHP**: Composer
-   **JavaScript**: NPM

### Development Dependencies

```json
{
    "autoprefixer": "^10.4.21",
    "axios": "^1.7.4",
    "concurrently": "^9.0.1",
    "laravel-vite-plugin": "^1.2.0",
    "postcss": "^8.5.3",
    "tailwindcss": "^3.4.17",
    "vite": "^6.0.11"
}
```

## Konfigurasi

### Vite

```javascript
import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
```

### Tailwind CSS

```javascript
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    darkMode: false,
    theme: {
        extend: {},
    },
    variants: {
        extend: {},
    },
    plugins: [],
};
```

## Development Scripts

```json
{
    "build": "vite build",
    "dev": "vite"
}
```

## Asset Management

### Directory Structure

```
resources/
├── css/
│   └── app.css      # Entry point untuk CSS
├── js/
│   └── app.js       # Entry point untuk JavaScript
└── views/           # Blade templates
```

### File Storage

-   **Thumbnail Storage**: `storage/app/public/thumbnails/`
-   **PDF Storage**: `storage/app/public/pdfs/`
-   **Public Access**: Via symlink ke `public/storage/`

## Security Features

### Authentication

-   Native Laravel authentication
-   Session-based auth
-   Password hashing dengan bcrypt
-   Remember me functionality

### File Upload Security

1. **Thumbnail Validation**

    - Format: jpeg, png, jpg
    - Max size: 2MB
    - Mime type verification

2. **PDF Validation**

    - Format: pdf only
    - Max size: 10MB
    - Mime type verification

3. **Storage Security**
    - Private storage dengan public symlink
    - Secure file naming
    - File existence validation

### Route Protection

-   Middleware authentication
-   Role-based access control
-   CSRF protection
-   Rate limiting

## Database Configuration

```php
'default' => env('DB_CONNECTION', 'sqlite'),

'connections' => [
    'sqlite' => [
        'driver' => 'sqlite',
        'database' => database_path('database.sqlite'),
        'prefix' => '',
        'foreign_key_constraints' => true,
    ],
],
```

## Cache & Session

-   Database-based session storage
-   Database-based cache storage
-   Queue system berbasis database

## Development Environment

-   Local development dengan Vite dev server
-   Hot module replacement untuk frontend
-   Database migrations & seeding
-   Storage linking otomatis

## Deployment Requirements

1. PHP 8.2+
2. Composer
3. Node.js & NPM
4. SQLite support
5. File permissions untuk storage & cache
6. Symlink capability

## Performance Optimizations

1. CSS & JS minification via Vite
2. Tailwind CSS purging unused styles
3. Response caching capabilities
4. Eager loading untuk relasi database
5. Lazy loading untuk assets

## Monitoring & Logging

1. Laravel built-in logging
2. Custom logging untuk file access
3. Query logging (development)
4. Error tracking
5. User activity logging

## Testing

-   PHPUnit untuk unit testing
-   Feature testing capability
-   Browser testing support
-   Factory patterns untuk test data

## Maintenance Mode

-   Built-in maintenance mode support
-   Custom maintenance page
-   Bypass untuk admin users
