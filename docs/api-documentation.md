# API & Route Documentation

Daftar endpoint dan route yang tersedia pada aplikasi Student Task Manager.

## 1. Otoritas Publik (Public Routes)
| Method | Endpoint | Fungsi |
|---|---|---|
| GET | `/` | Landing Page |
| GET | `/login` | Halaman Login |
| POST | `/login` | Proses Login |
| GET | `/register` | Halaman Pendaftaran |
| POST | `/register` | Proses Pendaftaran |

## 2. Otoritas Privat (Auth Required)
| Method | Endpoint | Fungsi |
|---|---|---|
| POST | `/logout` | Proses Keluar Sistem |
| GET | `/dashboard` | Dashboard Pengguna |

### Manajemen Kategori
| Method | Endpoint | Fungsi |
|---|---|---|
| GET | `/categories` | Daftar Kategori |
| GET | `/categories/create` | Form Tambah Kategori |
| POST | `/categories` | Simpan Kategori Baru |
| GET | `/categories/{id}/edit`| Form Edit Kategori |
| PUT | `/categories/{id}` | Update Data Kategori |
| DELETE| `/categories/{id}` | Hapus Kategori |

### Manajemen Tugas
| Method | Endpoint | Fungsi |
|---|---|---|
| GET | `/tasks` | Daftar Semua Tugas |
| GET | `/tasks/create` | Form Tambah Tugas |
| POST | `/tasks` | Simpan Tugas Baru |
| GET | `/tasks/{id}` | Detail Tugas |
| GET | `/tasks/{id}/edit` | Form Edit Tugas |
| PUT | `/tasks/{id}` | Update Data Tugas |
| DELETE| `/tasks/{id}` | Hapus Tugas |
| PATCH | `/tasks/{id}/status` | Update Status Tugas |

## Catatan
Semua route privat dilindungi oleh middleware `auth`, sehingga pengguna harus login terlebih dahulu untuk mengaksesnya.
