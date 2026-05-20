<?php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\TaskValidationService;

class TaskValidationServiceTest extends TestCase
{
	private TaskValidationService $service;
	
	protected function setUp(): void
	{
		parent::setUp();
		$this->service = new TaskValidationService();
	}
	
	// TC-UNIT-06: Path 1,2,4,6,8,10,11,13
	public function test_valid_title_valid_deadline_valid_categoryId()
	{
		$result = $this->service->validateTaskInput('test','2026/05/21','1');
		$this->assertTrue($result['is_valid']);
		$this->assertEmpty($result['errors']);
	}
	
	// TC-UNIT-07: Path 1.2.3.6,8,10,11,13
	public function test_empty_title_valid_deadline_valid_categoryId()
	{
		$result = $this->service->validateTaskInput('','2026/05/21','1');
		$this->assertFalse($result['is_valid']);
		$this->assertContains("Judul tugas wajib diisi.",$result['errors']);
	}
	
	// TC-UNIT-08: Path 1,2,4,5,6,8,10,11,13
	public function test_too_long_title_valid_deadline_valid_categoryId()
	{
		$result = $this->service->validateTaskInput(str_repeat('a', 256),'2026/05/21','1');
		$this->assertFalse($result['is_valid']);
		$this->assertContains("Judul tugas terlalu panjang.",$result['errors']);
	}
	
	// TC-UNIT-09: Path 1,2,4,6,7,10,11,13
	public function test_valid_title_empty_deadline_valid_categoryId()
	{
		$result = $this->service->validateTaskInput('test','','1');
		$this->assertFalse($result['is_valid']);
		$this->assertContains("Deadline wajib diisi.",$result['errors']);
	}
	
	// TC-UNIT-10: Path 1,2,4,6,8,9,10,11,13
	public function test_valid_title_invalid_deadline_valid_categoryId()
	{
		$result = $this->service->validateTaskInput('test','test','1');
		$this->assertFalse($result['is_valid']);
		$this->assertContains("Format deadline tidak valid.",$result['errors']);
	}
	
	// TC-UNIT-11: Path 1,2,4,6,8,10,12,13
	public function test_valid_title_valid_deadline_empty_categoryId()
	{
		$result = $this->service->validateTaskInput('test','2026/05/21','');
		$this->assertFalse($result['is_valid']);
		$this->assertContains("Kategori wajib dipilih.",$result['errors']);
	}
	
	// TC-UNIT-12: Path 1,2,4,6,8,10,12,13
	public function test_valid_title_valid_deadline_null_categoryId()
	{
		$result = $this->service->validateTaskInput('test','2026/05/21',NULL);
		$this->assertFalse($result['is_valid']);
		$this->assertContains("Kategori wajib dipilih.",$result['errors']);
	}
	
	// TC-UNIT-13: Path 1,2,4,6,8,10,11,12,13
	public function test_valid_title_valid_deadline_invalid_categoryId()
	{
		$result = $this->service->validateTaskInput('test','2026/05/21','0');
		$this->assertFalse($result['is_valid']);
		$this->assertContains("Kategori wajib dipilih.",$result['errors']);
	}
}