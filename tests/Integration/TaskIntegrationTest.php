<?php

namespace Tests\Integration;

use App\Models\Category;
use App\Models\Task;
use App\Models\User;
use App\Services\TaskPriorityService;
use App\Services\TaskValidationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\MockInterface;
use Tests\TestCase;

class TaskIntegrationTest extends TestCase
{
    use RefreshDatabase;

    
    public function test_guest_diarahkan_ke_login_saat_mengakses_tasks(): void
    {
        $response = $this->get(route('tasks.index'));

        $response->assertRedirect(route('login'));
    }

    
    public function test_user_login_dapat_melihat_daftar_task(): void
    {
        $user = User::factory()->create();

        $this->mock(TaskPriorityService::class, function (MockInterface $mock) {
            $mock->shouldReceive('calculateTaskPriority')->andReturn('Rendah');
        });

        $response = $this->actingAs($user)->get(route('tasks.index'));

        $response->assertOk();
        $response->assertViewIs('tasks.index');
    }

    
    public function test_create_task_hanya_menampilkan_kategori_milik_user_login(): void
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

        $response = $this->actingAs($user)->get(route('tasks.create'));

        $response->assertOk();
        $response->assertViewIs('tasks.create');

        $response->assertViewHas('categories', function ($categories) use ($ownCategory, $otherCategory) {
            return $categories->contains('id', $ownCategory->id)
                && !$categories->contains('id', $otherCategory->id);
        });
    }

    
    public function test_user_dapat_membuat_task_valid_dengan_validation_service_stub(): void
    {
        $user = User::factory()->create();

        $category = Category::factory()->create([
            'user_id' => $user->id,
            'name' => 'Kuliah',
        ]);

        $this->mock(TaskValidationService::class, function (MockInterface $mock) use ($category) {
            $mock->shouldReceive('validateTaskInput')
                ->once()
                ->with(
                    'Tugas Integration Testing',
                    '2026-12-31',
                    $category->id
                )
                ->andReturn([
                    'is_valid' => true,
                    'errors' => [],
                ]);
        });

        $response = $this->actingAs($user)->post(route('tasks.store'), [
            'category_id' => $category->id,
            'title' => 'Tugas Integration Testing',
            'description' => 'Menguji integrasi task menggunakan PHPUnit.',
            'deadline' => '2026-12-31',
        ]);

        $response->assertRedirect(route('tasks.index'));
        $response->assertSessionHas('success', 'Tugas berhasil ditambahkan.');

        $this->assertDatabaseHas('tasks', [
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Tugas Integration Testing',
            'description' => 'Menguji integrasi task menggunakan PHPUnit.',
            'status' => 'Belum Dikerjakan',
        ]);
    }

    
    public function test_task_gagal_dibuat_jika_title_kosong(): void
    {
        $user = User::factory()->create();

        $category = Category::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)
            ->from(route('tasks.create'))
            ->post(route('tasks.store'), [
                'category_id' => $category->id,
                'title' => '',
                'description' => 'Task invalid tanpa title',
                'deadline' => '2026-12-31',
            ]);

        $response->assertRedirect(route('tasks.create'));
        $response->assertSessionHasErrors();

        $this->assertDatabaseMissing('tasks', [
            'description' => 'Task invalid tanpa title',
        ]);
    }

    
    public function test_task_gagal_dibuat_jika_deadline_tidak_valid(): void
    {
        $user = User::factory()->create();

        $category = Category::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)
            ->from(route('tasks.create'))
            ->post(route('tasks.store'), [
                'category_id' => $category->id,
                'title' => 'Task Deadline Salah',
                'description' => 'Task invalid deadline',
                'deadline' => 'tanggal-salah',
            ]);

        $response->assertRedirect(route('tasks.create'));
        $response->assertSessionHasErrors();

        $this->assertDatabaseMissing('tasks', [
            'description' => 'Task invalid deadline',
        ]);
    }

    
    public function test_task_gagal_dibuat_jika_category_id_kosong(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->from(route('tasks.create'))
            ->post(route('tasks.store'), [
                'category_id' => '',
                'title' => 'Task Tanpa Kategori',
                'description' => 'Task invalid tanpa kategori',
                'deadline' => '2026-12-31',
            ]);

        $response->assertRedirect(route('tasks.create'));
        $response->assertSessionHasErrors();

        $this->assertDatabaseMissing('tasks', [
            'description' => 'Task invalid tanpa kategori',
        ]);
    }

    
    public function test_index_task_mendukung_search_dan_filter_status(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $category = Category::factory()->create([
            'user_id' => $user->id,
        ]);

        $otherCategory = Category::factory()->create([
            'user_id' => $otherUser->id,
        ]);

        $matchedTask = Task::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Belajar Laravel',
            'status' => 'Sedang Dikerjakan',
        ]);

        $notMatchedByStatus = Task::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Belajar Database',
            'status' => 'Selesai',
        ]);

        $notMatchedBySearch = Task::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Rapat Organisasi',
            'status' => 'Sedang Dikerjakan',
        ]);

        $otherUserTask = Task::factory()->create([
            'user_id' => $otherUser->id,
            'category_id' => $otherCategory->id,
            'title' => 'Belajar Laravel User Lain',
            'status' => 'Sedang Dikerjakan',
        ]);

        $this->mock(TaskPriorityService::class, function (MockInterface $mock) {
            $mock->shouldReceive('calculateTaskPriority')->andReturn('Tinggi');
        });

        $response = $this->actingAs($user)->get(route('tasks.index', [
            'search' => 'Belajar',
            'status' => 'Sedang Dikerjakan',
        ]));

        $response->assertOk();

        $response->assertViewHas('tasks', function ($tasks) use (
            $matchedTask,
            $notMatchedByStatus,
            $notMatchedBySearch,
            $otherUserTask
        ) {
            $items = $tasks->getCollection();

            return $items->contains('id', $matchedTask->id)
                && !$items->contains('id', $notMatchedByStatus->id)
                && !$items->contains('id', $notMatchedBySearch->id)
                && !$items->contains('id', $otherUserTask->id);
        });
    }

    
    public function test_user_dapat_melihat_detail_task_milik_sendiri(): void
    {
        $user = User::factory()->create();

        $category = Category::factory()->create([
            'user_id' => $user->id,
        ]);

        $task = Task::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Detail Task',
        ]);

        $this->mock(TaskPriorityService::class, function (MockInterface $mock) {
            $mock->shouldReceive('calculateTaskPriority')->once()->andReturn('Rendah');
        });

        $response = $this->actingAs($user)->get(route('tasks.show', $task));

        $response->assertOk();
        $response->assertViewIs('tasks.show');
        $response->assertViewHas('task', function ($taskFromView) use ($task) {
            return $taskFromView->id === $task->id
                && $taskFromView->priority === 'Rendah';
        });
    }

    
    public function test_user_tidak_dapat_melihat_task_milik_user_lain(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $otherCategory = Category::factory()->create([
            'user_id' => $otherUser->id,
        ]);

        $otherTask = Task::factory()->create([
            'user_id' => $otherUser->id,
            'category_id' => $otherCategory->id,
        ]);

        $response = $this->actingAs($user)->get(route('tasks.show', $otherTask));

        $response->assertForbidden();
    }

    
    public function test_user_dapat_update_task_milik_sendiri_dengan_validation_service_stub(): void
    {
        $user = User::factory()->create();

        $oldCategory = Category::factory()->create([
            'user_id' => $user->id,
        ]);

        $newCategory = Category::factory()->create([
            'user_id' => $user->id,
            'name' => 'Kategori Baru',
        ]);

        $task = Task::factory()->create([
            'user_id' => $user->id,
            'category_id' => $oldCategory->id,
            'title' => 'Task Lama',
            'description' => 'Deskripsi lama',
        ]);

        $this->mock(TaskValidationService::class, function (MockInterface $mock) use ($newCategory) {
            $mock->shouldReceive('validateTaskInput')
                ->once()
                ->with(
                    'Task Setelah Update',
                    '2026-12-30',
                    $newCategory->id
                )
                ->andReturn([
                    'is_valid' => true,
                    'errors' => [],
                ]);
        });

        $response = $this->actingAs($user)->put(route('tasks.update', $task), [
            'category_id' => $newCategory->id,
            'title' => 'Task Setelah Update',
            'description' => 'Deskripsi setelah update',
            'deadline' => '2026-12-30',
        ]);

        $response->assertRedirect(route('tasks.index'));
        $response->assertSessionHas('success', 'Tugas berhasil diperbarui.');

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'category_id' => $newCategory->id,
            'title' => 'Task Setelah Update',
            'description' => 'Deskripsi setelah update',
        ]);
    }

    
    public function test_update_task_gagal_jika_deadline_tidak_valid(): void
    {
        $user = User::factory()->create();

        $category = Category::factory()->create([
            'user_id' => $user->id,
        ]);

        $task = Task::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Task Original',
            'description' => 'Deskripsi original',
        ]);

        $response = $this->actingAs($user)
            ->from(route('tasks.edit', $task))
            ->put(route('tasks.update', $task), [
                'category_id' => $category->id,
                'title' => 'Task Deadline Invalid',
                'description' => 'Data tidak boleh berubah',
                'deadline' => 'tanggal-salah',
            ]);

        $response->assertRedirect(route('tasks.edit', $task));
        $response->assertSessionHasErrors();

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'Task Original',
            'description' => 'Deskripsi original',
        ]);
    }

    
    public function test_user_tidak_dapat_update_task_milik_user_lain(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $otherCategory = Category::factory()->create([
            'user_id' => $otherUser->id,
        ]);

        $otherTask = Task::factory()->create([
            'user_id' => $otherUser->id,
            'category_id' => $otherCategory->id,
            'title' => 'Task User Lain',
        ]);

        $response = $this->actingAs($user)->put(route('tasks.update', $otherTask), [
            'category_id' => $otherCategory->id,
            'title' => 'Hacked Task',
            'description' => 'Tidak boleh berubah',
            'deadline' => '2026-12-31',
        ]);

        $response->assertForbidden();

        $this->assertDatabaseHas('tasks', [
            'id' => $otherTask->id,
            'title' => 'Task User Lain',
        ]);
    }

    
    public function test_user_dapat_update_status_task(): void
    {
        $user = User::factory()->create();

        $category = Category::factory()->create([
            'user_id' => $user->id,
        ]);

        $task = Task::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'status' => 'Belum Dikerjakan',
        ]);

        $response = $this->actingAs($user)
            ->from(route('tasks.index'))
            ->patch(route('tasks.updateStatus', $task), [
                'status' => 'Selesai',
            ]);

        $response->assertRedirect(route('tasks.index'));
        $response->assertSessionHas('success', 'Status tugas berhasil diperbarui.');

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'status' => 'Selesai',
        ]);
    }

    
    public function test_update_status_gagal_jika_status_invalid(): void
    {
        $user = User::factory()->create();

        $category = Category::factory()->create([
            'user_id' => $user->id,
        ]);

        $task = Task::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'status' => 'Belum Dikerjakan',
        ]);

        $response = $this->actingAs($user)
            ->from(route('tasks.index'))
            ->patch(route('tasks.updateStatus', $task), [
                'status' => 'Arsip',
            ]);

        $response->assertRedirect(route('tasks.index'));
        $response->assertSessionHasErrors(['status']);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'status' => 'Belum Dikerjakan',
        ]);
    }

    
    public function test_user_dapat_menghapus_task_milik_sendiri(): void
    {
        $user = User::factory()->create();

        $category = Category::factory()->create([
            'user_id' => $user->id,
        ]);

        $task = Task::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Task Akan Dihapus',
        ]);

        $response = $this->actingAs($user)->delete(route('tasks.destroy', $task));

        $response->assertRedirect(route('tasks.index'));
        $response->assertSessionHas('success', 'Tugas berhasil dihapus.');

        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id,
        ]);
    }

    
    public function test_user_tidak_dapat_menghapus_task_milik_user_lain(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $otherCategory = Category::factory()->create([
            'user_id' => $otherUser->id,
        ]);

        $otherTask = Task::factory()->create([
            'user_id' => $otherUser->id,
            'category_id' => $otherCategory->id,
            'title' => 'Task User Lain',
        ]);

        $response = $this->actingAs($user)->delete(route('tasks.destroy', $otherTask));

        $response->assertForbidden();

        $this->assertDatabaseHas('tasks', [
            'id' => $otherTask->id,
            'title' => 'Task User Lain',
        ]);
    }
}