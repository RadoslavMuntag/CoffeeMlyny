<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ProductCategorySeeder::class,
            ProductSeeder::class,
            CouponSeeder::class,
            UserSeeder::class,
            PaymentMethodsSeeder::class,
            ShippingMethodsSeeder::class,
        ]);
    }
}
