<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\TemplateCategory;
use App\Models\Software;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call(CategorySeeder::class);
        $this->call(UserSeeder::class);
        $this->call(SoftwareSeeder::class);

    }
}
