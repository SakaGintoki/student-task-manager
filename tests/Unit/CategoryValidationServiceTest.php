<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\CategoryValidationService;

class CategoryValidationServiceTest extends TestCase
{
    protected $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new CategoryValidationService();
    }

    // TC-UNIT-18 / Path 1: nama kategori kosong.
    public function test_validate_category_empty_name()
    {
        $result = $this->service->validateCategoryInput('', 'Kategori untuk tugas kuliah');

        $this->assertFalse($result['is_valid']);
        $this->assertCount(1, $result['errors']);
        $this->assertContains('Nama kategori wajib diisi.', $result['errors']);
    }

    // TC-UNIT-19 / Path 2: nama kategori terlalu panjang.
    public function test_validate_category_long_name()
    {
        $result = $this->service->validateCategoryInput(str_repeat('A', 256), 'Kategori untuk tugas kuliah');

        $this->assertFalse($result['is_valid']);
        $this->assertCount(1, $result['errors']);
        $this->assertContains('Nama kategori terlalu panjang.', $result['errors']);
    }

    // TC-UNIT-20 / Path 3: deskripsi kategori terlalu panjang.
    public function test_validate_category_long_description()
    {
        $result = $this->service->validateCategoryInput('Kuliah', str_repeat('A', 1001));

        $this->assertFalse($result['is_valid']);
        $this->assertCount(1, $result['errors']);
        $this->assertContains('Deskripsi kategori terlalu panjang.', $result['errors']);
    }

    // TC-UNIT-21 / Path 4: nama valid dan deskripsi kosong.
    public function test_validate_category_success_with_empty_description()
    {
        $result = $this->service->validateCategoryInput('Kuliah', null);

        $this->assertTrue($result['is_valid']);
        $this->assertEmpty($result['errors']);
    }

    // TC-UNIT-22 / Path 5: semua input valid.
    public function test_validate_category_success()
    {
        $result = $this->service->validateCategoryInput('Kuliah', 'Kategori untuk tugas kuliah');

        $this->assertTrue($result['is_valid']);
        $this->assertEmpty($result['errors']);
    }
}
