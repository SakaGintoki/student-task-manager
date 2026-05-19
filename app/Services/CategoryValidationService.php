<?php

namespace App\Services;

class CategoryValidationService
{
    /**
     * Memvalidasi input kategori.
     */
    public function validateCategoryInput(?string $name, ?string $description): array
    {
        $errors = [];

        if (empty($name)) {
            $errors[] = "Nama kategori wajib diisi.";
        } else if (strlen($name) > 255) {
            $errors[] = "Nama kategori terlalu panjang.";
        }

        if ($description !== null && strlen($description) > 1000) {
            $errors[] = "Deskripsi kategori terlalu panjang.";
        }

        return [
            'is_valid' => empty($errors),
            'errors' => $errors
        ];
    }
}
