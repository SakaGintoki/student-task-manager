<?php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\TaskPriorityService;

class TaskPriorityServiceTest extends TestCase
{
	private TaskPriorityService $service;
	
	protected function setUp(): void
	{
		parent::setUp();
		$this->service = new TaskPriorityService();
	}
	
	// TC-UNIT-14: Path 1,2,12
	public function test_empty_deadline()
	{
		$result = $this->service->calculateTaskPriority('');
		$this->assertEquals('No deadline set',$result);
	}
	
	// TC-UNIT-15: Path 1,3,11,12
	public function test_exception_deadline()
	{
		$result = $this->service->calculateTaskPriority('test');
		$this->assertEquals('Err',$result);
	}
	
	// TC-UNIT-16: Path 1,3,4,5,12
	public function test_deadline_yesterday()
	{
		$result = $this->service->calculateTaskPriority('-1 day');
		$this->assertEquals('Sangat Tinggi (Overdue)',$result);
	}
	
	// TC-UNIT-17: Path 1,3,4,6,7,12
	public function test_deadline_tomorrow()
	{
		$result = $this->service->calculateTaskPriority('+1 day');
		$this->assertEquals('Tinggi',$result);
	}
	
	// TC-UNIT-18: Path 1,3,4,6,8,10,12
	public function test_deadline_in_5_days()
	{
		$result = $this->service->calculateTaskPriority('+5 days');
		$this->assertEquals('Rendah',$result);
	}
	
	// TC-UNIT-19: Path 1,3,4,6,8,9,12
	public function test_deadline_in_3_days()
	{
		$result = $this->service->calculateTaskPriority('+3 days');
		$this->assertEquals('Medium',$result);
	}
}