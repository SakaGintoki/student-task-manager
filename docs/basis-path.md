# Basis Path Testing

Basis Path Testing adalah teknik White Box Testing yang memastikan setiap jalur independen dalam program setidaknya dieksekusi satu kali.

## Fungsi: `AuthValidationService::validateLoginInput`

Berdasarkan nilai Cyclomatic Complexity (V(G) = 5), terdapat minimal 5 jalur independen yang harus diuji.

### Daftar Basis Path

| Path ID | Jalur Eksekusi (Node) | Skenario Input |
|---|---|---|
| Path 1 | 1 -> 2 -> 5 -> 6 -> 9 | Email kosong, Password kosong |
| Path 2 | 1 -> 3 -> 5 -> 7 -> 9 | Email valid, Password valid |
| Path 3 | 1 -> 3 -> 4 -> 5 -> 7 -> 9 | Email tidak valid, Password valid |
| Path 4 | 1 -> 3 -> 5 -> 7 -> 8 -> 9 | Email valid, Password terlalu pendek |
| Path 5 | 1 -> 2 -> 5 -> 7 -> 8 -> 9 | Email kosong, Password terlalu pendek |

### Penjelasan Path
1.  **Path 1**: Menguji kondisi `if (empty($email))` (True) dan `if (empty($password))` (True).
2.  **Path 2**: Menguji kondisi `if (empty($email))` (False), `filter_var` (True), `if (empty($password))` (False), dan `strlen` (True). Ini adalah jalur sukses.
3.  **Path 3**: Menguji kondisi format email salah namun password benar.
4.  **Path 4**: Menguji kondisi email benar namun password tidak memenuhi syarat panjang minimal.
5.  **Path 5**: Menguji kombinasi email kosong dan password pendek.

## Kesimpulan
Dengan menguji kelima jalur di atas, kita telah mencapai **100% Basis Path Coverage** untuk fungsi `validateLoginInput`.
