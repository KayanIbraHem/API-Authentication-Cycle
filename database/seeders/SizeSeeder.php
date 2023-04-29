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
        $name = ['XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL'];
        foreach ($name as $n) {
            Size::create(['name' => $n]);
        }
    }
}
