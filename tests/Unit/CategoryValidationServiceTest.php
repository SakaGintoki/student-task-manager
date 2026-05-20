<?php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\CategoryValidationService;

class CategoryValidationServiceTest extends TestCase
{
	private CategoryValidationService $service;
	
	protected function setUp(): void
	{
		parent::setUp();
		$this->service = new CategoryValidationService();
	}
	
	// TC-UNIT-01: Path 1→2→4→6→7→9
	public function test_valid_name_valid_description()
	{
		$result = $this->service->validateCategoryInput('test','test');
		$this->assertTrue($result['is_valid']);
		$this->assertEmpty($result['errors']);
	}
	
	// TC-UNIT-02: Path 1→2→3→6→7→9
	public function test_empty_name_valid_description()
	{
		$result = $this->service->validateCategoryInput('','test');
		$this->assertFalse($result['is_valid']);
		$this->assertContains("Nama kategori wajib diisi.",$result['errors']);
	}
	
	// TC-UNIT-03: Path 1→2→4→5→6→7→9
	public function test_name_too_long_valid_description()
	{
		$result = $this->service->validateCategoryInput(str_repeat('a', 256),'test');
		$this->assertFalse($result['is_valid']);
		$this->assertContains("Nama kategori terlalu panjang.",$result['errors']);
	}
	
	// TC-UNIT-04: Path 1→2→4→6→9
	public function test_valid_name_empty_description()
	{
		$result = $this->service->validateCategoryInput('test','');
		$this->assertTrue($result['is_valid']);
		$this->assertEmpty($result['errors']);
	}
	
	// TC-UNIT-05: Path 1→2→4→6→7→8→9
	public function test_valid_name_but_too_long_description()
	{
		$result = $this->service->validateCategoryInput('test',str_repeat('a', 1001));
		$this->assertFalse($result['is_valid']);
		$this->assertContains("Deskripsi kategori terlalu panjang.",$result['errors']);
	}
}