<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            'category_id' => 1,
            'name' => 'iPhone 15',
            'slug' => 'iphone-15',
            'sku' => 'IPHONE15',
            'description' => 'Apple smartphone',
            'price' => 70000,
            'discount_price' => 65000,
            'stock_quantity' => 10,
            'status' => 1
        ]);
    }
}