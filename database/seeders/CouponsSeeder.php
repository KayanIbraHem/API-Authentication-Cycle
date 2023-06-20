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
            'type' => 'fixed',
            'type_of_use' => 1,
            'max_uses' => 12,
            'value' => 100,
            // 'max_discount' => 100,
            'minimum_of_total' => 300,
            'current_uses' => 0,
            'start_date' => '2023-06-03',
            'expiry_date' => '2023-06-06',
        ]);
        Coupon::create([
            'code' => 'H456',
            'type' => 'precent',
            'max_uses' => 1,
            'precent_off' => 10,
            'max_discount' => 100,
            'minimum_of_total' => 300,
            'current_uses' => 0,
            'start_date' => '2023-06-03',
            'expiry_date' => '2023-06-06',
        ]);
    }
}
