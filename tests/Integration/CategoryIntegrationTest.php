<?php

namespace Tests\Integration;

use App\Models\Category;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryIntegrationTest extends TestCase
{
    use RefreshDatabase;

    
    public function test_guest_diarahkan_ke_login_saat_mengakses_categories(): void
    {
        $response = $this->get(route('categories.index'));

        $response->assertRedirect(route('login'));
    }

    
    public function test_user_login_dapat_melihat_daftar_kategori(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('categories.index'));

        $response->assertOk();
        $response->assertViewIs('categories.index');
    }

    
    public function test_daftar_kategori_hanya_menampilkan_kategori_milik_user_login(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $ownCategory = Category::factory()->create([
            'user_id' => $user->id,
            'name' => 'Kuliah',
        ]);

        $otherCategory = Category::factory()->create([
            'user_id' => $otherUser->id,
            'name' => 'Kategori User Lain',
        ]);

        $response = $this->actingAs($user)->get(route('categories.index'));

        $response->assertOk();

        $response->assertViewHas('categories', function ($categories) use ($ownCategory, $otherCategory) {
            return $categories->contains('id', $ownCategory->id)
                && !$categories->contains('id', $otherCategory->id);
        });
    }

    
    public function test_user_dapat_membuat_kategori_valid(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('categories.store'), [
            'name' => 'Akademik',
            'description' => 'Kategori untuk tugas kuliah',
        ]);

        $response->assertRedirect(route('categories.index'));
        $response->assertSessionHas('success', 'Kategori berhasil ditambahkan.');

        $this->assertDatabaseHas('categories', [
            'user_id' => $user->id,
            'name' => 'Akademik',
            'description' => 'Kategori untuk tugas kuliah',
        ]);
    }

    
    public function test_kategori_gagal_dibuat_jika_name_kosong(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->from(route('categories.create'))
            ->post(route('categories.store'), [
                'name' => '',
                'description' => 'Kategori tanpa nama',
            ]);

        $response->assertRedirect(route('categories.create'));
        $response->assertSessionHasErrors(['name']);

        $this->assertDatabaseMissing('categories', [
            'description' => 'Kategori tanpa nama',
        ]);
    }

    
    public function test_kategori_gagal_dibuat_jika_name_terlalu_panjang(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->from(route('categories.create'))
            ->post(route('categories.store'), [
                'name' => str_repeat('A', 256),
                'description' => 'Nama kategori terlalu panjang',
            ]);

        $response->assertRedirect(route('categories.create'));
        $response->assertSessionHasErrors(['name']);

        $this->assertDatabaseMissing('categories', [
            'description' => 'Nama kategori terlalu panjang',
        ]);
    }

    
    public function test_user_dapat_update_kategori_milik_sendiri(): void
    {
        $user = User::factory()->create();

        $category = Category::factory()->create([
            'user_id' => $user->id,
            'name' => 'Kategori Lama',
            'description' => 'Deskripsi lama',
        ]);

        $response = $this->actingAs($user)->put(route('categories.update', $category), [
            'name' => 'Kategori Baru',
            'description' => 'Deskripsi baru',
        ]);

        $response->assertRedirect(route('categories.index'));
        $response->assertSessionHas('success', 'Kategori berhasil diperbarui.');

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'user_id' => $user->id,
            'name' => 'Kategori Baru',
            'description' => 'Deskripsi baru',
        ]);
    }

    
    public function test_update_kategori_gagal_jika_name_kosong(): void
    {
        $user = User::factory()->create();

        $category = Category::factory()->create([
            'user_id' => $user->id,
            'name' => 'Kategori Lama',
        ]);

        $response = $this->actingAs($user)
            ->from(route('categories.edit', $category))
            ->put(route('categories.update', $category), [
                'name' => '',
                'description' => 'Deskripsi tidak valid',
            ]);

        $response->assertRedirect(route('categories.edit', $category));
        $response->assertSessionHasErrors(['name']);

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'Kategori Lama',
        ]);
    }

    
    public function test_user_tidak_dapat_update_kategori_milik_user_lain(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $otherCategory = Category::factory()->create([
            'user_id' => $otherUser->id,
            'name' => 'Kategori User Lain',
        ]);

        $response = $this->actingAs($user)->put(route('categories.update', $otherCategory), [
            'name' => 'Kategori Diubah Paksa',
            'description' => 'Tidak boleh berubah',
        ]);

        $response->assertForbidden();

        $this->assertDatabaseHas('categories', [
            'id' => $otherCategory->id,
            'name' => 'Kategori User Lain',
        ]);
    }

    
    public function test_user_dapat_menghapus_kategori_milik_sendiri(): void
    {
        $user = User::factory()->create();

        $category = Category::factory()->create([
            'user_id' => $user->id,
            'name' => 'Kategori Dihapus',
        ]);

        $response = $this->actingAs($user)->delete(route('categories.destroy', $category));

        $response->assertRedirect(route('categories.index'));
        $response->assertSessionHas('success', 'Kategori berhasil dihapus.');

        $this->assertDatabaseMissing('categories', [
            'id' => $category->id,
        ]);
    }

    
    public function test_user_tidak_dapat_menghapus_kategori_milik_user_lain(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $otherCategory = Category::factory()->create([
            'user_id' => $otherUser->id,
            'name' => 'Kategori User Lain',
        ]);

        $response = $this->actingAs($user)->delete(route('categories.destroy', $otherCategory));

        $response->assertForbidden();

        $this->assertDatabaseHas('categories', [
            'id' => $otherCategory->id,
            'name' => 'Kategori User Lain',
        ]);
    }

    
    public function test_kategori_index_menampilkan_jumlah_task(): void
    {
        $user = User::factory()->create();

        $category = Category::factory()->create([
            'user_id' => $user->id,
            'name' => 'Kuliah',
        ]);

        Task::factory()->count(2)->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);

        $response = $this->actingAs($user)->get(route('categories.index'));

        $response->assertOk();

        $response->assertViewHas('categories', function ($categories) use ($category) {
            $categoryFromView = $categories->firstWhere('id', $category->id);

            return $categoryFromView !== null
                && $categoryFromView->tasks_count === 2;
        });
    }
}