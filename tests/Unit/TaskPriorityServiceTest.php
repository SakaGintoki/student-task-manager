<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\TaskPriorityService;
use Carbon\Carbon;

class TaskPriorityServiceTest extends TestCase
{
    protected $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new TaskPriorityService();
    }

    // TC-UNIT-12 / Path 1: deadline kosong.
    public function test_priority_empty_deadline()
    {
        $result = $this->service->calculateTaskPriority(null);
        $this->assertEquals('Normal', $result);
    }

    // TC-UNIT-13 / Path 2: deadline tidak dapat di-parse dan masuk catch.
    public function test_priority_invalid_deadline()
    {
        $result = $this->service->calculateTaskPriority('invalid-xyz');
        $this->assertEquals('Normal', $result);
    }

    // TC-UNIT-14 / Path 3: deadline sudah lewat.
    public function test_priority_overdue()
    {
        $deadline = Carbon::now()->subDay()->toDateTimeString();
        $result = $this->service->calculateTaskPriority($deadline);
        $this->assertEquals('Sangat Tinggi (Overdue)', $result);
    }

    // TC-UNIT-15 / Path 4: deadline kurang dari atau sama dengan 1 hari.
    public function test_priority_high()
    {
        $deadline = Carbon::now()->addHours(12)->toDateTimeString();
        $result = $this->service->calculateTaskPriority($deadline);
        $this->assertEquals('Tinggi', $result);
    }

    // TC-UNIT-16 / Path 5: deadline 2 sampai 3 hari.
    public function test_priority_medium()
    {
        $deadline = Carbon::now()->addDays(2)->toDateTimeString();
        $result = $this->service->calculateTaskPriority($deadline);
        $this->assertEquals('Medium', $result);
    }

    // TC-UNIT-17 / Path 6: deadline lebih dari 3 hari.
    public function test_priority_low()
    {
        $deadline = Carbon::now()->addDays(5)->toDateTimeString();
        $result = $this->service->calculateTaskPriority($deadline);
        $this->assertEquals('Rendah', $result);
    }
}
