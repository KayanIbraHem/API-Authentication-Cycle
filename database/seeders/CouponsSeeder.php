<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CouponsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('coupons')->delete();
        Coupon::create([
            'code' => 'K123',
            'type' => 1,
            'max_uses' => 12,
            'discount' => 10,
            'max_discount' => 100,
            'minimum_of_total' => 300,
            'current_uses' => 0,
            'start_date' => '2023-06-03',
            'expiry_date' => '2023-06-06',
        ]);
        Coupon::create([
            'code' => 'H456',
            'type' => 0,
            'max_uses' => 1,
            'discount' => 10,
            'max_discount' => 100,
            'minimum_of_total' => 300,
            'current_uses' => 0,
            'start_date' => '2023-06-03',
            'expiry_date' => '2023-06-06',
        ]);
    }
}
