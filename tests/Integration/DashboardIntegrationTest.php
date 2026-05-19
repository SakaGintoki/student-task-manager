<?php

namespace Tests\Integration;

use App\Models\Category;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardIntegrationTest extends TestCase
{
    use RefreshDatabase;

    
    public function test_guest_diarahkan_ke_login_saat_mengakses_dashboard(): void
    {
        $response = $this->get(route('dashboard'));

        $response->assertRedirect(route('login'));
    }

    
    public function test_user_login_dapat_mengakses_dashboard(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertOk();
        $response->assertViewIs('dashboard');
    }

    
    public function test_dashboard_menampilkan_statistik_milik_user_login(): void
    {
        $user = User::factory()->create();

        $categoryA = Category::factory()->create([
            'user_id' => $user->id,
            'name' => 'Kuliah',
        ]);

        $categoryB = Category::factory()->create([
            'user_id' => $user->id,
            'name' => 'Organisasi',
        ]);

        Task::factory()->create([
            'user_id' => $user->id,
            'category_id' => $categoryA->id,
            'status' => 'Belum Dikerjakan',
        ]);

        Task::factory()->create([
            'user_id' => $user->id,
            'category_id' => $categoryA->id,
            'status' => 'Sedang Dikerjakan',
        ]);

        Task::factory()->create([
            'user_id' => $user->id,
            'category_id' => $categoryB->id,
            'status' => 'Selesai',
        ]);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertOk();
        $response->assertViewHas('taskCount', 3);
        $response->assertViewHas('completedTaskCount', 1);
        $response->assertViewHas('categoryCount', 2);
        $response->assertViewHas('statusCounts', [
            'belum' => 1,
            'sedang' => 1,
            'selesai' => 1,
        ]);
    }

    
    public function test_dashboard_tidak_menghitung_data_milik_user_lain(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $ownCategory = Category::factory()->create([
            'user_id' => $user->id,
            'name' => 'Kategori Sendiri',
        ]);

        $otherCategory = Category::factory()->create([
            'user_id' => $otherUser->id,
            'name' => 'Kategori User Lain',
        ]);

        Task::factory()->create([
            'user_id' => $user->id,
            'category_id' => $ownCategory->id,
            'status' => 'Selesai',
        ]);

        Task::factory()->create([
            'user_id' => $otherUser->id,
            'category_id' => $otherCategory->id,
            'status' => 'Selesai',
        ]);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertOk();
        $response->assertViewHas('taskCount', 1);
        $response->assertViewHas('completedTaskCount', 1);
        $response->assertViewHas('categoryCount', 1);
        $response->assertViewHas('statusCounts', [
            'belum' => 0,
            'sedang' => 0,
            'selesai' => 1,
        ]);
    }
}