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

    public function test_validate_task_success()
    {
        $result = $this->service->validateTaskInput('Tugas PPL', '2026-12-31', 1);
        $this->assertTrue($result['is_valid']);
        $this->assertEmpty($result['errors']);
    }

    public function test_validate_task_empty_title()
    {
        $result = $this->service->validateTaskInput('', '2026-12-31', 1);
        $this->assertFalse($result['is_valid']);
        $this->assertContains('Judul tugas wajib diisi.', $result['errors']);
    }

    public function test_validate_task_empty_deadline()
    {
        $result = $this->service->validateTaskInput('Tugas PPL', '', 1);
        $this->assertFalse($result['is_valid']);
        $this->assertContains('Deadline wajib diisi.', $result['errors']);
    }

    public function test_validate_task_invalid_deadline()
    {
        $result = $this->service->validateTaskInput('Tugas PPL', 'bukan-tanggal', 1);
        $this->assertFalse($result['is_valid']);
        $this->assertContains('Format deadline tidak valid.', $result['errors']);
    }

    public function test_validate_task_invalid_category()
    {
        $result = $this->service->validateTaskInput('Tugas PPL', '2026-12-31', 0);
        $this->assertFalse($result['is_valid']);
        $this->assertContains('Kategori wajib dipilih.', $result['errors']);
    }
}
