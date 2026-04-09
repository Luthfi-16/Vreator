<?php

namespace Database\Seeders;

use App\Models\Software;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SoftwareSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $softwares = [
            'Adobe After Effects',
            'Adobe Lightroom',
            'Adobe Premier Pro',
            'Adobe Photoshop',
            'Alight Motion',
            'Canva',
            'Davinci Resolve'
        ];

        foreach ($softwares as $software) {
            Software::create([
                'name' => $software,
                'slug' => Str::slug($software),
            ]);
        }
    }
}
