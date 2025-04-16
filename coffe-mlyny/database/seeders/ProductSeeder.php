<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run()
{
    Product::insert([
        [
            'name' => 'Guatemala Dark',
            'description' => 'From The Volcanic Soil',
            'price' => 18.99,
            'category' => 'Single Origin',
            'image' => 'assets/products/single-origin/guatemala_dark_500.jpg',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'name' => 'Espresso Medium',
            'description' => 'A Bold Kick',
            'price' => 18.99,
            'category' => 'Blends',
            'image' => 'assets/products/blends/espresso_medium_500.jpg',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'name' => 'Yemen Medium',
            'description' => 'From The Hidden Valleys',
            'price' => 18.99,
            'category' => 'Limited Edition',
            'image' => 'assets/products/limited-edition/yemen_medium_500.jpg',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'name' => 'Swiss Decaf',
            'description' => 'A Chocolatey Sip',
            'price' => 18.99,
            'category' => 'Specials & Decaf',
            'image' => 'assets/products/decaf-specials/swissdecaf_medium_500.jpg',
            'created_at' => now(),
            'updated_at' => now()
        ],
    ]);
}
}
