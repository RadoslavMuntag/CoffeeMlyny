<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ShippingMethodsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('shipping_methods')->insert([
            ['name' => 'Standard Shipping', 'price' => 5.99],
            ['name' => 'Express Shipping', 'price' => 11.99],
        ]);
        
    }
}
