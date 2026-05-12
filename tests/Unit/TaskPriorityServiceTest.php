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

    public function test_priority_empty_deadline()
    {
        $result = $this->service->calculateTaskPriority(null);
        $this->assertEquals('Normal', $result);
    }

    public function test_priority_overdue()
    {
        $deadline = Carbon::now()->subDay()->toDateTimeString();
        $result = $this->service->calculateTaskPriority($deadline);
        $this->assertEquals('Sangat Tinggi (Overdue)', $result);
    }

    public function test_priority_high()
    {
        $deadline = Carbon::now()->addHours(12)->toDateTimeString();
        $result = $this->service->calculateTaskPriority($deadline);
        $this->assertEquals('Tinggi', $result);
    }

    public function test_priority_medium()
    {
        $deadline = Carbon::now()->addDays(2)->toDateTimeString();
        $result = $this->service->calculateTaskPriority($deadline);
        $this->assertEquals('Medium', $result);
    }

    public function test_priority_low()
    {
        $deadline = Carbon::now()->addDays(5)->toDateTimeString();
        $result = $this->service->calculateTaskPriority($deadline);
        $this->assertEquals('Rendah', $result);
    }
}
