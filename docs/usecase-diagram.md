# Use Case Diagram

Diagram Use Case menggambarkan interaksi antara aktor (Mahasiswa) dan sistem.

```mermaid
useCaseDiagram
    actor Mahasiswa
    
    Mahasiswa --> (Register)
    Mahasiswa --> (Login)
    Mahasiswa --> (Logout)
    Mahasiswa --> (Kelola Kategori)
    Mahasiswa --> (Kelola Tugas)
    Mahasiswa --> (Ubah Status Tugas)
    Mahasiswa --> (Lihat Dashboard)
    
    (Kelola Kategori) ..> (Login) : include
    (Kelola Tugas) ..> (Login) : include
    (Ubah Status Tugas) ..> (Login) : include
    (Lihat Dashboard) ..> (Login) : include
```

## Penjelasan Aktor
- **Mahasiswa**: Pengguna terdaftar yang memiliki otoritas untuk mengelola datanya sendiri (tugas dan kategori).

## Penjelasan Use Case
1.  **Register**: Proses pembuatan akun baru agar bisa mengakses sistem.
2.  **Login**: Proses verifikasi identitas pengguna untuk masuk ke area privat.
3.  **Logout**: Mengakhiri sesi pengguna.
4.  **Kelola Kategori**: Meliputi operasi Create, Read, Update, dan Delete data kategori.
5.  **Kelola Tugas**: Meliputi operasi Create, Read, Update, dan Delete data tugas.
6.  **Ubah Status Tugas**: Proses mengubah progress tugas dari belum dikerjakan, sedang dikerjakan, hingga selesai.
7.  **Lihat Dashboard**: Melihat ringkasan statistik tugas secara visual.
