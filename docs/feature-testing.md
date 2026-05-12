# Feature Testing

Feature testing (atau Integration Testing) menguji alur proses bisnis secara end-to-end, mulai dari request HTTP hingga perubahan di database.

## Skenario Pengujian

### 1. Autentikasi (AuthTest)
- Memastikan halaman login dan register dapat diakses.
- Memastikan pengguna baru dapat mendaftar.
- Memastikan pengguna dapat masuk dengan kredensial yang benar.
- Memastikan sistem menolak login dengan password salah.

### 2. Manajemen Kategori (CategoryFeatureTest)
- Memastikan pengguna yang login dapat melihat daftar kategori.
- Memastikan kategori baru dapat disimpan ke database.
- Memastikan kategori dapat diperbarui.
- Memastikan kategori dapat dihapus.

### 3. Manajemen Tugas (TaskFeatureTest)
- Memastikan tugas baru dapat dibuat dan terhubung ke kategori.
- Memastikan detail tugas menampilkan informasi yang benar.
- Memastikan status tugas dapat diubah (Proses Bisnis Multi-langkah).
- Memastikan tugas dapat dihapus.

## Cara Menjalankan
Jalankan perintah berikut di terminal:
```bash
php artisan test --testsuite=Feature
```

## Alur Pengujian Multi-langkah (Ubah Status)
Pengujian pada `test_user_can_update_task_status` mensimulasikan:
1.  Sistem memiliki tugas dengan status 'Belum Dikerjakan'.
2.  User mengirim request PATCH untuk mengubah ke 'Sedang Dikerjakan'.
3.  Sistem memverifikasi status berubah di database.
4.  User mengirim request PATCH lagi untuk mengubah ke 'Selesai'.
5.  Sistem memverifikasi status akhir.
