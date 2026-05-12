<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_authenticated_user_can_view_categories()
    {
        $response = $this->actingAs($this->user)->get('/categories');
        $response->assertStatus(200);
    }

    public function test_user_can_create_category()
    {
        $response = $this->actingAs($this->user)->post('/categories', [
            'name' => 'Kuliah',
            'description' => 'Kategori untuk tugas kuliah',
        ]);

        $response->assertRedirect('/categories');
        $this->assertDatabaseHas('categories', ['name' => 'Kuliah']);
    }

    public function test_user_can_edit_category()
    {
        $category = Category::factory()->create(['user_id' => $this->user->id]);

        $response = $this->actingAs($this->user)->put("/categories/{$category->id}", [
            'name' => 'Kuliah Updated',
        ]);

        $response->assertRedirect('/categories');
        $this->assertDatabaseHas('categories', ['name' => 'Kuliah Updated']);
    }

    public function test_user_can_delete_category()
    {
        $category = Category::factory()->create(['user_id' => $this->user->id]);

        $response = $this->actingAs($this->user)->delete("/categories/{$category->id}");

        $response->assertRedirect('/categories');
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }
}
