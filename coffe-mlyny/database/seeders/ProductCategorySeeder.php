<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductCategory;

class ProductCategorySeeder extends Seeder
{
    public function run()
    {
        $categories = ['Single Origin', 'Blends', 'Limited Edition', 'Specials & Decaf'];

        foreach ($categories as $name) {
            ProductCategory::create(['name' => $name]);
        }
    }
}
