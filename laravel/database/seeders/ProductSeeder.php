<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $category = Category::create(['name' => 'Electronics', 'slug' => 'electronics']);

        Product::create([
            'name' => 'Smartphone',
            'description' => 'A high-end smartphone with advanced features.',
            'price' => 699.99,
            'stock' => 50,
            'category_id' => $category->id,
        ]);

        Product::create([
            'name' => 'Laptop',
            'description' => 'Powerful laptop for work and entertainment.',
            'price' => 1299.99,
            'stock' => 30,
            'category_id' => $category->id,
        ]);

        // Add more products as needed
    }
}