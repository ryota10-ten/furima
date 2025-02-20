<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ListingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'user_id' => '1',
            'product_id' => '1',
        ];
        DB::table('listings')->insert($param);
        $param = [
            'user_id' => '1',
            'product_id' => '2',
        ];
        DB::table('listings')->insert($param);
        $param = [
            'user_id' => '1',
            'product_id' => '3',
        ];
        DB::table('listings')->insert($param);
        $param = [
            'user_id' => '1',
            'product_id' => '4',
        ];
        DB::table('listings')->insert($param);
        $param = [
            'user_id' => '1',
            'product_id' => '5',
        ];
        DB::table('listings')->insert($param);
        $param = [
            'user_id' => '1',
            'product_id' => '6',
        ];
        DB::table('listings')->insert($param);
        $param = [
            'user_id' => '1',
            'product_id' => '7',
        ];
        DB::table('listings')->insert($param);
        $param = [
            'user_id' => '1',
            'product_id' => '8',
        ];
        DB::table('listings')->insert($param);
        $param = [
            'user_id' => '1',
            'product_id' => '9',
        ];
        DB::table('listings')->insert($param);
        $param = [
            'user_id' => '1',
            'product_id' => '10',
        ];
        DB::table('listings')->insert($param);
    }
}
