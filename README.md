# TaskOrbit: Student Workspace

**TaskOrbit** (sebelumnya Student Task Manager) adalah aplikasi Manajemen Tugas Mahasiswa modern yang dirancang khusus untuk memenuhi kebutuhan tugas mata kuliah Pengujian Perangkat Lunak (PPL). Aplikasi ini mengutamakan antarmuka yang bersih (UI/UX modern), kemudahan pengujian (white-box & black-box), dan dokumentasi rekayasa perangkat lunak yang lengkap.

## Fitur Utama Baru (Update)

- **UI/UX Modern**: Desain responsif menggunakan Bootstrap 5 dengan kustomisasi CSS bergaya *Glassmorphism* dan *Flat Design*. Dilengkapi dengan animasi mikro, shadow lembut, dan tipografi modern (Google Fonts: Poppins).
- **Dashboard Analitik**: Visualisasi data statistik status tugas menggunakan **Chart.js**. Menampilkan rasio penyelesaian tugas dan ringkasan prioritas.
- **Pencarian & Filter Tugas**: Fitur untuk mencari tugas berdasarkan judul dan menyaring tugas berdasarkan status penyelesaian secara *real-time* via Query String.
- **Manajemen Kategori Visual**: Tampilan kategori menggunakan model *Card Grid* dengan indikator jumlah tugas di dalam setiap kategori.
- **Autentikasi**: Register, Login, dan Logout dengan UI *split-screen/card* modern.
- **Proses Bisnis Multi-langkah**: Alur penyelesaian tugas yang jelas (Belum Dikerjakan -> Sedang Dikerjakan -> Selesai).
- **Kalkulasi Prioritas Otomatis**: Penentuan prioritas (Sangat Tinggi, Tinggi, Medium, Rendah) yang dikalkulasi otomatis oleh Service layer berdasarkan sisa waktu *deadline*.

## Teknologi

- **Framework**: Laravel 12
- **Bahasa**: PHP 8.5+
- **Database**: MySQL / MariaDB
- **Frontend**: Bootstrap 5, FontAwesome 6, Chart.js, Google Fonts (Poppins)
- **Testing**: PHPUnit & Laravel Feature Test

## Struktur Project

```text
student-task-manager/
├── app/
│   ├── Http/Controllers/    # Logika alur aplikasi (termasuk fitur search/filter)
│   ├── Models/               # Struktur data database
│   └── Services/             # Logika bisnis (Target utama White-box Testing CFG)
├── database/
│   ├── migrations/           # Skema tabel database MySQL
│   └── seeders/              # Data dummy awal (Admin & Mahasiswa)
├── docs/                     # Dokumentasi pengujian lengkap (RTM, CFG, Basis Path)
├── resources/views/          # Antarmuka pengguna (Blade Template Modern UI)
├── routes/web.php            # Definisi endpoint/URL
└── tests/                    # File pengujian unit & fitur (16+ Tests)
```

## Cara Install

1. Clone repository ini.
2. Buka terminal di dalam folder project dan jalankan: `composer install`
3. Salin file environment: `cp .env.example .env`
4. Buat kunci aplikasi: `php artisan key:generate`
5. **Konfigurasi Database**: Buka file `.env`, atur `DB_CONNECTION=mysql` dan sesuaikan kredensial (pastikan Anda sudah membuat database kosong di MySQL bernama `student_task_manager`).
6. Lakukan migrasi beserta *seeding* data awal: `php artisan migrate --seed`
7. Jalankan server lokal: `php artisan serve`
8. Buka browser: `http://localhost:8000`

*(Data login *seeder* awal: Email: `mahasiswa@ppl.com` | Password: `password`)*

## Pengujian (Testing)

Aplikasi ini dilengkapi dengan pengujian otomatis berstandar industri:

- **Unit Test**: `php artisan test --testsuite=Unit` (Menguji komponen logika bisnis / validasi).
- **Feature Test**: `php artisan test --testsuite=Feature` (Menguji *end-to-end* alur sistem dan API web).

Dokumentasi lengkap mengenai analisis pengujian (CFG, Cyclomatic Complexity, RTM, Usecase) dapat dilihat di folder `docs/`.

## Author
[Nama Anda / Mahasiswa]
Tugas Pengujian Perangkat Lunak 2026
