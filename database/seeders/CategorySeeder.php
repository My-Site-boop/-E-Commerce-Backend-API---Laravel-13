<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::create([
            'name' => 'Mobiles',
            'slug' => 'mobiles',
            'status' => 1
        ]);

        Category::create([
            'name' => 'Laptops',
            'slug' => 'laptops',
            'status' => 1
        ]);
    }
}