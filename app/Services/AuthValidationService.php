<?php

namespace App\Services;

class AuthValidationService
{
    /**
     * Memvalidasi input login.
     * Fungsi ini dirancang untuk White Box Testing (CFG Analysis).
     */
    public function validateLoginInput(?string $email, ?string $password): array
    {
        $errors = [];

        // Node 1: Cek apakah email kosong
        if (empty($email)) {
            $errors[] = "Email wajib diisi."; // Node 2
        } else {
            // Node 3: Cek format email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Format email tidak valid."; // Node 4
            }
        }

        // Node 5: Cek apakah password kosong
        if (empty($password)) {
            $errors[] = "Password wajib diisi."; // Node 6
        } else {
            // Node 7: Cek panjang password
            if (strlen($password) < 8) {
                $errors[] = "Password minimal 8 karakter."; // Node 8
            }
        }

        // Node 9: Tentukan hasil validasi
        return [
            'is_valid' => empty($errors),
            'errors' => $errors
        ];
    }
}
