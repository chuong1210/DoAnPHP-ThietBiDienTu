<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // database/seeders/CouponSeeder.php
        Coupon::create([
            'code' => 'WELCOME10',
            'type' => 'percent',
            'value' => 10,
            'min_order' => 500000,
            'max_discount' => 100000, // Giảm tối đa 100k
            'max_uses' => 100,
            'start_date' => now(),
            'end_date' => now()->addDays(30),
            'is_active' => true,
        ]);

        Coupon::create([
            'code' => 'FREESHIP',
            'type' => 'fixed',
            'value' => 30000,
            'min_order' => 300000,
            'max_discount' => null, // Không cần max với fixed
            'max_uses' => 200,
            'start_date' => now(),
            'end_date' => now()->addDays(60),
            'is_active' => true,
        ]);
    }
}
