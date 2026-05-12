<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Category;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $category;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->category = Category::factory()->create(['user_id' => $this->user->id]);
    }

    public function test_user_can_create_task()
    {
        $response = $this->actingAs($this->user)->post('/tasks', [
            'title' => 'Tugas PPL',
            'category_id' => $this->category->id,
            'deadline' => now()->addDays(7)->toDateTimeString(),
            'description' => 'Mengerjakan unit testing',
        ]);

        $response->assertRedirect('/tasks');
        $this->assertDatabaseHas('tasks', ['title' => 'Tugas PPL']);
    }

    public function test_user_can_view_task_detail()
    {
        $task = Task::factory()->create([
            'user_id' => $this->user->id,
            'category_id' => $this->category->id
        ]);

        $response = $this->actingAs($this->user)->get("/tasks/{$task->id}");
        $response->assertStatus(200);
        $response->assertSee($task->title);
    }

    public function test_user_can_update_task_status()
    {
        $task = Task::factory()->create([
            'user_id' => $this->user->id,
            'category_id' => $this->category->id,
            'status' => 'Belum Dikerjakan'
        ]);

        $response = $this->actingAs($this->user)->patch("/tasks/{$task->id}/status", [
            'status' => 'Sedang Dikerjakan'
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'status' => 'Sedang Dikerjakan'
        ]);
    }

    public function test_user_can_delete_task()
    {
        $task = Task::factory()->create([
            'user_id' => $this->user->id,
            'category_id' => $this->category->id
        ]);

        $response = $this->actingAs($this->user)->delete("/tasks/{$task->id}");

        $response->assertRedirect('/tasks');
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
