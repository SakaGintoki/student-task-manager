# Control Flow Graph (CFG) Analysis

Analisis CFG dilakukan untuk memahami alur eksekusi kode dan menentukan jalur pengujian (White Box Testing).

## Fungsi: `AuthValidationService::validateLoginInput`

### Source Code
```php
public function validateLoginInput(?string $email, ?string $password): array
{
    $errors = [];

    // Node 1
    if (empty($email)) {
        $errors[] = "Email wajib diisi."; // Node 2
    } else {
        // Node 3
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Format email tidak valid."; // Node 4
        }
    }

    // Node 5
    if (empty($password)) {
        $errors[] = "Password wajib diisi."; // Node 6
    } else {
        // Node 7
        if (strlen($password) < 8) {
            $errors[] = "Password minimal 8 karakter."; // Node 8
        }
    }

    // Node 9
    return [
        'is_valid' => empty($errors),
        'errors' => $errors
    ];
}
```

### Control Flow Graph (Mermaid)
```mermaid
graph TD
    N1[Node 1: is email empty?]
    N2[Node 2: add error empty email]
    N3[Node 3: is email format invalid?]
    N4[Node 4: add error invalid email]
    N5[Node 5: is password empty?]
    N6[Node 6: add error empty password]
    N7[Node 7: is password < 8 chars?]
    N8[Node 8: add error short password]
    N9[Node 9: return result]

    N1 -- Yes --> N2
    N1 -- No --> N3
    N2 --> N5
    N3 -- Yes --> N4
    N3 -- No --> N5
    N4 --> N5
    N5 -- Yes --> N6
    N5 -- No --> N7
    N6 --> N9
    N7 -- Yes --> N8
    N7 -- No --> N9
    N8 --> N9
```

### Daftar Node
- **Node 1**: Decision - Pengecekan apakah email kosong.
- **Node 2**: Statement - Penambahan error "Email wajib diisi".
- **Node 3**: Decision - Pengecekan format email.
- **Node 4**: Statement - Penambahan error "Format email tidak valid".
- **Node 5**: Decision - Pengecekan apakah password kosong.
- **Node 6**: Statement - Penambahan error "Password wajib diisi".
- **Node 7**: Decision - Pengecekan panjang password.
- **Node 8**: Statement - Penambahan error "Password minimal 8 karakter".
- **Node 9**: Statement - Return hasil validasi.
