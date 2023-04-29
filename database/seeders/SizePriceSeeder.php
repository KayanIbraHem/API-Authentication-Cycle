<?php

namespace Database\Seeders;

use App\Models\Price;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SizePriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('size_price')->delete();
        $name = [1 => 100, 2 => 200, 3 => 300, 4 => 400, 5 => 500, 6 => 600, 7 => 700];
        foreach ($name as $key => $value) {
            Price::create(['size_id' => $key, 'price' => $value]);
        }
    }
}
