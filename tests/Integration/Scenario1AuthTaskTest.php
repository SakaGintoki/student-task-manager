<?php

namespace Tests\Integration;

use App\Models\Category;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class Scenario1AuthTaskTest extends TestCase
{
	use RefreshDatabase;
	
	// TC-INT-01
	public function test_unauthed_user_access_taska()
	{
		$response = $this->get('/tasks');
		$response->assertStatus(302);
		$response->assertRedirect('/login');
	}
	
	// TC-INT-02
	public function test_authed_user_access_tasks()
	{
		$user = User::factory()->create();
		$response = $this->actingAs($user)->get('/tasks');
		$response->assertStatus(200);
	}
	
	// TC-INT-03
	public function test_authed_user_filter_title()
	{
		$user = User::factory()->create();
		$category = Category::factory()->create(['user_id' => $user->id]);
		Task::factory()->create
		([
			'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'PPL Tugas 1'
		]);
		Task::factory()->create
		([
			'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'EAI Tugas 1'
		]);
		
		$response = $this->actingAs($user)->get('/tasks?search=PPL');
		$response->assertStatus(200);
		$response->assertSee('PPL Tugas 1');
		$response->assertDontSee('EAI Tugas 1');
	}
	
	// TC-INT-04
	public function test_authed_user_filter_status()
	{
		$user = User::factory()->create();
		$category = Category::factory()->create(['user_id' => $user->id]);
		Task::factory()->create
		([
			'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'PPL Tugas 2',
			'status' => 'Sedang Dikerjakan'
		]);
		Task::factory()->create
		([
			'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'EAI Tugas 2',
			'status' => 'Selesai'
		]);
		
		$response = $this->actingAs($user)->get('/tasks?status=Sedang Dikerjakan');
		$response->assertStatus(200);
		//$response->assertSee('Sedang Dikerjakan');
		$response->assertSee('PPL Tugas 2');
		//$response->assertDontSee('Selesai');
		$response->assertDontSee('EAI Tugas 2');
	}
}
