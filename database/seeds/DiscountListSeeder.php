<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiscountListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('discount_list')->insert([
            ['discount_value' => 50, 'discount_count' => 15],
            ['discount_value' => 100, 'discount_count' => 12],
            ['discount_value' => 200, 'discount_count' => 10],
            ['discount_value' => 500, 'discount_count' => 8],
            ['discount_value' => 1000, 'discount_count' => 5],
            ['discount_value' => 2000, 'discount_count' => 4],
            ['discount_value' => 5000, 'discount_count' => 2],
            ['discount_value' => 10000, 'discount_count' => 1],
        ]);
    }
}
