<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Task;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat User Mahasiswa
        $user = User::factory()->create([
            'name' => 'Mahasiswa PPL',
            'email' => 'mahasiswa@ppl.com',
            'password' => Hash::make('password'),
            'role' => 'mahasiswa',
        ]);

        // Buat Kategori
        $categories = [
            ['name' => 'Kuliah', 'description' => 'Tugas mata kuliah harian'],
            ['name' => 'Project', 'description' => 'Project akhir semester'],
            ['name' => 'Organisasi', 'description' => 'Kegiatan organisasi kampus'],
        ];

        foreach ($categories as $cat) {
            $category = $user->categories()->create($cat);

            // Buat beberapa tugas untuk setiap kategori
            Task::factory(3)->create([
                'user_id' => $user->id,
                'category_id' => $category->id,
            ]);
        }

        // Buat User Admin
        User::factory()->create([
            'name' => 'Admin PPL',
            'email' => 'admin@ppl.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
    }
}
