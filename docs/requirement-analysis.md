# Requirement Analysis

Analisis kebutuhan sistem untuk aplikasi Student Task Manager.

## 1. Deskripsi Sistem
Student Task Manager adalah aplikasi berbasis web yang membantu mahasiswa mengelola daftar tugas mereka. Mahasiswa dapat mengelompokkan tugas berdasarkan kategori, menetapkan deadline, dan memantau status pengerjaan tugas.

## 2. Tujuan Sistem
- Memudahkan mahasiswa dalam melakukan manajemen waktu.
- Memberikan visibilitas terhadap tugas yang mendesak.
- Menyediakan platform yang terorganisir untuk pencatatan tugas.

## 3. Aktor Sistem
1.  **Mahasiswa**: Pengguna utama yang mengelola tugas dan kategori.
2.  **Admin**: (Opsional/Future Scope) Mengelola data pengguna secara global.

## 4. Functional Requirement (FR)
| ID | Kebutuhan | Deskripsi |
|---|---|---|
| REQ-01 | Register Akun | Pengguna dapat mendaftarkan akun baru. |
| REQ-02 | Login Sistem | Pengguna dapat masuk ke sistem menggunakan email & password. |
| REQ-03 | Logout Sistem | Pengguna dapat keluar dari sistem dengan aman. |
| REQ-04 | CRUD Kategori | Pengguna dapat menambah, melihat, mengubah, dan menghapus kategori. |
| REQ-05 | CRUD Tugas | Pengguna dapat menambah, melihat, mengubah, dan menghapus tugas. |
| REQ-06 | Ubah Status | Pengguna dapat mengubah status tugas (Belum -> Sedang -> Selesai). |
| REQ-07 | Validasi Input | Sistem harus melakukan validasi pada setiap input data. |
| REQ-08 | Dashboard | Sistem menampilkan ringkasan jumlah tugas dan status di dashboard. |

## 5. Non-Functional Requirement (NFR)
1.  **Usability**: Antarmuka pengguna harus sederhana dan mudah dipahami.
2.  **Security**: Password pengguna harus di-hash menggunakan algoritma yang aman (Bcrypt).
3.  **Performance**: Setiap permintaan halaman harus diproses dalam waktu kurang dari 2 detik.
4.  **Reliability**: Data yang disimpan tidak boleh hilang dan harus konsisten.
