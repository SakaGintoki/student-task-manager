<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\AuthValidationService;

class AuthValidationServiceTest extends TestCase
{
    protected $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new AuthValidationService();
    }

    // TC-UNIT-01 / Path 1: email kosong dan password kosong.
    public function test_validate_login_empty_email_and_empty_password()
    {
        $result = $this->service->validateLoginInput('', '');
        $this->assertFalse($result['is_valid']);
        $this->assertCount(2, $result['errors']);
        $this->assertContains('Email wajib diisi.', $result['errors']);
        $this->assertContains('Password wajib diisi.', $result['errors']);
    }

    // TC-UNIT-02 / Path 2: email kosong dan password terlalu pendek.
    public function test_validate_login_empty_email_and_short_password()
    {
        $result = $this->service->validateLoginInput('', 'pass12');
        $this->assertFalse($result['is_valid']);
        $this->assertCount(2, $result['errors']);
        $this->assertContains('Email wajib diisi.', $result['errors']);
        $this->assertContains('Password minimal 8 karakter.', $result['errors']);
    }

    // TC-UNIT-03 / Path 3: format email tidak valid dan password kosong.
    public function test_validate_login_invalid_email_format_and_empty_password()
    {
        $result = $this->service->validateLoginInput('invalid-email', '');
        $this->assertFalse($result['is_valid']);
        $this->assertCount(2, $result['errors']);
        $this->assertContains('Format email tidak valid.', $result['errors']);
        $this->assertContains('Password wajib diisi.', $result['errors']);
    }

    // TC-UNIT-04 / Path 4: semua input valid.
    public function test_validate_login_success()
    {
        $result = $this->service->validateLoginInput('user@example.com', 'password123');
        $this->assertTrue($result['is_valid']);
        $this->assertEmpty($result['errors']);
    }

    // TC-UNIT-05 / Path 5: email valid dan password terlalu pendek.
    public function test_validate_login_short_password()
    {
        $result = $this->service->validateLoginInput('user@example.com', '12345');
        $this->assertFalse($result['is_valid']);
        $this->assertContains('Password minimal 8 karakter.', $result['errors']);
    }

    // Tambahan: isolasi error email kosong saja.
    public function test_validate_login_empty_email()
    {
        $result = $this->service->validateLoginInput('', 'password123');
        $this->assertFalse($result['is_valid']);
        $this->assertContains('Email wajib diisi.', $result['errors']);
    }

    // Tambahan: isolasi error format email saja.
    public function test_validate_login_invalid_email_format()
    {
        $result = $this->service->validateLoginInput('invalid-email', 'password123');
        $this->assertFalse($result['is_valid']);
        $this->assertContains('Format email tidak valid.', $result['errors']);
    }

    // Tambahan: isolasi error password kosong saja.
    public function test_validate_login_empty_password()
    {
        $result = $this->service->validateLoginInput('user@example.com', '');
        $this->assertFalse($result['is_valid']);
        $this->assertContains('Password wajib diisi.', $result['errors']);
    }
}
