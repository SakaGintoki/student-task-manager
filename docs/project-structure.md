# Project Structure

Penjelasan mengenai struktur folder pada Student Task Manager (Laravel).

## Folder Utama

- **`app/`**: Folder pusat logika aplikasi.
  - **`Http/Controllers/`**: Menangani logika request-response dan alur navigasi.
  - **`Http/Requests/`**: Berisi class untuk validasi form request.
  - **`Models/`**: Definisi struktur tabel database dan relasi antar tabel (ORM Eloquent).
  - **`Services/`**: Layer tambahan untuk logika bisnis yang kompleks dan target utama white-box testing.

- **`database/`**: Folder manajemen basis data.
  - **`migrations/`**: Versi kontrol untuk skema tabel database.
  - **`factories/`**: Template pembuatan data dummy untuk testing.
  - **`seeders/`**: Pengisian data awal ke database.

- **`resources/`**: Folder aset mentah.
  - **`views/`**: Template antarmuka pengguna menggunakan Blade.

- **`routes/`**: Folder definisi URL/Route.
  - **`web.php`**: Route untuk akses web browser.

- **`tests/`**: Folder khusus pengujian.
  - **`Unit/`**: Tes untuk komponen individu secara terisolasi.
  - **`Feature/`**: Tes untuk fitur/alur proses secara keseluruhan.

- **`docs/`**: Dokumentasi teknis, analisis pengujian, dan panduan instalasi.

- **`public/`**: Folder publik (CSS, JS, Image) yang dapat diakses langsung oleh browser.
