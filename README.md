# Perpustakaan-BLDSP

Sistem Perpustakaan BLDSP menggunakan Laravel.

## Cara Instalasi

1. Clone repository

```bash
git clone https://github.com/bimapopo345/Perpustakaan-Bldsp.git .
```

2. Install dependencies menggunakan Composer

```bash
composer install
```

3. Copy file .env.example ke .env dan generate key aplikasi

```bash
copy .env.example .env && php artisan key:generate
```

4. Buat database MySQL

```bash
mysql -u root -e "CREATE DATABASE IF NOT EXISTS perpustakaan_bldsp;"
```

5. Konfigurasi database di file .env
   Cari bagian konfigurasi database dan ubah menjadi:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=perpustakaan_bldsp
DB_USERNAME=root
DB_PASSWORD=
```

6. Jalankan migrasi database

```bash
php artisan migrate
```

7. Jalankan server Laravel

```bash
php artisan serve
```

Setelah menjalankan langkah-langkah di atas, aplikasi dapat diakses melalui:

-   http://127.0.0.1:8000 (menggunakan Laravel development server)
-   http://localhost/perpus-tes (jika menggunakan XAMPP)
