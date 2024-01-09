<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Hari;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Nama hari dalam Bahasa Inggris
        $daysEn = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        // Nama hari dalam Bahasa Indonesia
        $daysId = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

        // Menggunakan perulangan untuk membuat hari-hari
        for ($i = 0; $i < count($daysEn); $i++) {
            Hari::factory()->create([
                'day_en' => $daysEn[$i],
                'day_id' => $daysId[$i],
            ]);
        }
    }
}
