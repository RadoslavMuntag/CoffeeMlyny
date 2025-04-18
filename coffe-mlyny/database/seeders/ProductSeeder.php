<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                'name' => 'Guatemala',
                'variant' => 'Dark',
                'description' => 'From The Volcanic Soil',
                'price' => 18.99,
                'weight' => 250,
                'stock' => 100,
                'category' => 'Single Origin',
                'images' => [
                    'assets/products/single-origin/guatemala_dark_250.jpg'
                ]
            ],
            [
                'name' => 'Espresso',
                'variant' => 'Medium',
                'description' => 'A Bold Kick',
                'price' => 19.99,
                'weight' => 250,
                'stock' => 150,
                'category' => 'Blends',
                'images' => [
                    'assets/products/blends/espresso_medium_250.jpg'
                ]
            ],
            [
                'name' => 'Guatemala',
                'variant' => 'Dark',
                'description' => 'From The Volcanic Soil',
                'price' => 18.99,
                'weight' => 500,
                'stock' => 100,
                'category' => 'Single Origin',
                'images' => [
                    'assets/products/single-origin/guatemala_dark_500.jpg'
                ]
            ],
            [
                'name' => 'Espresso',
                'variant' => 'Medium',
                'description' => 'A Bold Kick',
                'price' => 19.99,
                'weight' => 500,
                'stock' => 150,
                'category' => 'Blends',
                'images' => [
                    'assets/products/blends/espresso_medium_500.jpg'
                ]
            ],
        ];

        foreach ($products as $data) {
            $category = ProductCategory::where('name', $data['category'])->first();
            $product = Product::create([
                'name' => $data['name'],
                'variant' => $data['variant'],
                'description' => $data['description'],
                'price' => $data['price'],
                'weight' => $data['weight'],
                'stock' => $data['stock'],
                'product_category_id' => $category->id,
            ]);

            foreach ($data['images'] as $image) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $image,
                ]);
            }
        }
    }
}
