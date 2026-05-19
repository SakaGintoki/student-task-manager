<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\TaskValidationService;

class TaskValidationServiceTest extends TestCase
{
    protected $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new TaskValidationService();
    }

    // TC-UNIT-06 / Path 1: title kosong, deadline kosong, kategori tidak valid.
    public function test_validate_task_empty_title_deadline_and_invalid_category()
    {
        $result = $this->service->validateTaskInput('', '', 0);
        $this->assertFalse($result['is_valid']);
        $this->assertCount(3, $result['errors']);
        $this->assertContains('Judul tugas wajib diisi.', $result['errors']);
        $this->assertContains('Deadline wajib diisi.', $result['errors']);
        $this->assertContains('Kategori wajib dipilih.', $result['errors']);
    }

    // TC-UNIT-07 / Path 2: title terlalu panjang, deadline kosong, kategori tidak valid.
    public function test_validate_task_long_title_empty_deadline_and_invalid_category()
    {
        $result = $this->service->validateTaskInput(str_repeat('A', 256), '', 0);
        $this->assertFalse($result['is_valid']);
        $this->assertCount(3, $result['errors']);
        $this->assertContains('Judul tugas terlalu panjang.', $result['errors']);
        $this->assertContains('Deadline wajib diisi.', $result['errors']);
        $this->assertContains('Kategori wajib dipilih.', $result['errors']);
    }

    // TC-UNIT-08 / Path 3: title valid, deadline kosong, kategori tidak valid.
    public function test_validate_task_empty_deadline_and_invalid_category()
    {
        $result = $this->service->validateTaskInput('Tugas', '', 0);
        $this->assertFalse($result['is_valid']);
        $this->assertCount(2, $result['errors']);
        $this->assertContains('Deadline wajib diisi.', $result['errors']);
        $this->assertContains('Kategori wajib dipilih.', $result['errors']);
    }

    // TC-UNIT-09 / Path 4: title valid, deadline tidak valid, kategori tidak valid.
    public function test_validate_task_invalid_deadline_and_invalid_category()
    {
        $result = $this->service->validateTaskInput('Tugas', 'bukan-tanggal', 0);
        $this->assertFalse($result['is_valid']);
        $this->assertCount(2, $result['errors']);
        $this->assertContains('Format deadline tidak valid.', $result['errors']);
        $this->assertContains('Kategori wajib dipilih.', $result['errors']);
    }

    // TC-UNIT-10 / Path 5: title valid, deadline valid, kategori tidak valid.
    public function test_validate_task_invalid_category()
    {
        $result = $this->service->validateTaskInput('Tugas PPL', '2026-12-31', 0);
        $this->assertFalse($result['is_valid']);
        $this->assertContains('Kategori wajib dipilih.', $result['errors']);
    }

    // TC-UNIT-11 / Path 6: semua input valid.
    public function test_validate_task_success()
    {
        $result = $this->service->validateTaskInput('Tugas PPL', '2026-12-31', 1);
        $this->assertTrue($result['is_valid']);
        $this->assertEmpty($result['errors']);
    }

    // // Tambahan: isolasi error title kosong saja.
    // public function test_validate_task_empty_title()
    // {
    //     $result = $this->service->validateTaskInput('', '2026-12-31', 1);
    //     $this->assertFalse($result['is_valid']);
    //     $this->assertContains('Judul tugas wajib diisi.', $result['errors']);
    // }

    // // Tambahan: isolasi error deadline kosong saja.
    // public function test_validate_task_empty_deadline()
    // {
    //     $result = $this->service->validateTaskInput('Tugas PPL', '', 1);
    //     $this->assertFalse($result['is_valid']);
    //     $this->assertContains('Deadline wajib diisi.', $result['errors']);
    // }

    // // Tambahan: isolasi error format deadline saja.
    // public function test_validate_task_invalid_deadline()
    // {
    //     $result = $this->service->validateTaskInput('Tugas PPL', 'bukan-tanggal', 1);
    //     $this->assertFalse($result['is_valid']);
    //     $this->assertContains('Format deadline tidak valid.', $result['errors']);
    // }
}
