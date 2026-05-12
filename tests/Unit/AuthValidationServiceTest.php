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

    public function test_validate_login_success()
    {
        $result = $this->service->validateLoginInput('user@example.com', 'password123');
        $this->assertTrue($result['is_valid']);
        $this->assertEmpty($result['errors']);
    }

    public function test_validate_login_empty_email()
    {
        $result = $this->service->validateLoginInput('', 'password123');
        $this->assertFalse($result['is_valid']);
        $this->assertContains('Email wajib diisi.', $result['errors']);
    }

    public function test_validate_login_invalid_email_format()
    {
        $result = $this->service->validateLoginInput('invalid-email', 'password123');
        $this->assertFalse($result['is_valid']);
        $this->assertContains('Format email tidak valid.', $result['errors']);
    }

    public function test_validate_login_empty_password()
    {
        $result = $this->service->validateLoginInput('user@example.com', '');
        $this->assertFalse($result['is_valid']);
        $this->assertContains('Password wajib diisi.', $result['errors']);
    }

    public function test_validate_login_short_password()
    {
        $result = $this->service->validateLoginInput('user@example.com', '12345');
        $this->assertFalse($result['is_valid']);
        $this->assertContains('Password minimal 8 karakter.', $result['errors']);
    }
}
