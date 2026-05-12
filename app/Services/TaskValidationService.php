<?php

namespace App\Services;

class TaskValidationService
{
    /**
     * Memvalidasi input tugas.
     * Fungsi ini dirancang untuk White Box Testing (CFG Analysis).
     */
    public function validateTaskInput(?string $title, ?string $deadline, ?int $categoryId): array
    {
        $errors = [];

        // Node 1: Cek judul
        if (empty($title)) {
            $errors[] = "Judul tugas wajib diisi."; // Node 2
        } else if (strlen($title) > 255) {
            $errors[] = "Judul tugas terlalu panjang."; // Node 3
        }

        // Node 4: Cek deadline
        if (empty($deadline)) {
            $errors[] = "Deadline wajib diisi."; // Node 5
        } else {
            // Node 6: Cek format tanggal (sederhana)
            if (!strtotime($deadline)) {
                $errors[] = "Format deadline tidak valid."; // Node 7
            }
        }

        // Node 8: Cek kategori
        if ($categoryId === null || $categoryId <= 0) {
            $errors[] = "Kategori wajib dipilih."; // Node 9
        }

        // Node 10: Selesai
        return [
            'is_valid' => empty($errors),
            'errors' => $errors
        ];
    }
}
