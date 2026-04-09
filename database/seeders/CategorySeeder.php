<?php

namespace Database\Seeders;

use App\Models\TemplateCategory;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Color Grading',
            'Cinematic',
            'Poster',
            'Thumbnail',
            'Transitions',
            'Typhography',
        ];

        foreach ($categories as $category) {
            TemplateCategory::create([
                'name' => $category,
                'slug' => Str::slug($category),
            ]);
        }
    }
}
