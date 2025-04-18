<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Coupon;

class CouponSeeder extends Seeder
{
    public function run()
    {
        $coupons = [
            ['code' => 'TRIBE10', 'discount_amount' => 10, 'expires_at' => '2025-07-06 11:23:12'],
            ['code' => 'ZUBROWKA15', 'discount_amount' => 15, 'expires_at' => '2025-05-13 11:23:12'],
            ['code' => 'MACHNAC20', 'discount_amount' => 20, 'expires_at' => '2025-05-01 11:23:12'],
        ];

        foreach ($coupons as $coupon) {
            Coupon::create($coupon);
        }
    }
}
