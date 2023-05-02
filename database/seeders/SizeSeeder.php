<?php

namespace Database\Seeders;

use App\Models\Size;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sizes')->delete();
        $name = ['XS' => 100, 'S' => 200, 'M' => 300, 'L' => 400, 'XL' => 500, 'XXL' => 600, 'XXXL' => 700];
        foreach ($name as $key => $value) {
            Size::create(['name' => $key, 'price' => $value]);
        }
    }
}
