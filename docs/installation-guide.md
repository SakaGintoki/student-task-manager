# Installation Guide

Panduan instalasi aplikasi Student Task Manager di lingkungan lokal.

## Prasyarat (Prerequisites)
Pastikan perangkat Anda sudah terinstall:
- PHP >= 8.2
- Composer
- MySQL atau MariaDB
- Web Browser (Chrome/Firefox)

## Langkah-langkah Instalasi

### 1. Persiapan Project
Download atau clone project ini ke direktori lokal Anda:
```bash
git clone <repository-url>
cd student-task-manager
```

### 2. Instalasi Dependency
Gunakan Composer untuk mendownload library Laravel:
```bash
composer install
```

### 3. Konfigurasi Environment
Salin file `.env.example` menjadi `.env`:
```bash
cp .env.example .env
```
Generate kunci enkripsi aplikasi:
```bash
php artisan key:generate
```

### 4. Setup Database
Buka file `.env` dan sesuaikan pengaturan database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=student_task_manager
DB_USERNAME=root
DB_PASSWORD=
```
*Pastikan database `student_task_manager` sudah dibuat di MySQL Anda.*

### 5. Migrasi Database
Jalankan migrasi untuk membuat tabel-tabel sistem:
```bash
php artisan migrate
```

### 6. Menjalankan Aplikasi
Nyalakan server development Laravel:
```bash
php artisan serve
```
Akses aplikasi melalui browser di: `http://127.0.0.1:8000`

### 7. Verifikasi (Testing)
Untuk memastikan instalasi berhasil dan sistem berjalan normal, jalankan test:
```bash
php artisan test
```
