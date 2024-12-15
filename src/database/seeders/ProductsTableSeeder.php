<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'name' => '腕時計',
            'img' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Armani+Mens+Clock.jpg',
            'price' => '15000',
            'detail' => 'スタイリッシュなデザインのメンズ腕時計',
            'condition_id' => '1',
        ];
        DB::table('products')->insert($param);
        $param = [
            'name' => 'HDD',
            'img' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/HDD+Hard+Disk.jpg',
            'price' => '5000',
            'detail' => '高速で信頼性の高いハードディスク',
            'condition_id' => '2',
        ];
        DB::table('products')->insert($param);
        $param = [
            'name' => '玉ねぎ3束',
            'img' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/iLoveIMG+d.jpg',
            'price' => '300',
            'detail' => '新鮮な玉ねぎ3束のセット',
            'condition_id' => '3',
        ];
        DB::table('products')->insert($param);
        $param = [
            'name' => '革靴',
            'img' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Leather+Shoes+Product+Photo.jpg',
            'price' => '4000',
            'detail' => 'クラシックなデザインの革靴',
            'condition_id' => '3',
        ];
        DB::table('products')->insert($param);
        $param = [
            'name' => '玉ねぎ3束',
            'img' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/iLoveIMG+d.jpg',
            'price' => '300',
            'detail' => '新鮮な玉ねぎ3束のセット',
            'condition_id' => '4',
        ];
        DB::table('products')->insert($param);
        $param = [
            'name' => 'ノートPC',
            'img' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Living+Room+Laptop.jpg',
            'price' => '45000',
            'detail' => '高性能なノートパソコン',
            'condition_id' => '1',
        ];
        DB::table('products')->insert($param);
        $param = [
            'name' => 'マイク',
            'img' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Music+Mic+4632231.jpg',
            'price' => '8000',
            'detail' => '高音質のレコーディング用マイク',
            'condition_id' => '2',
        ];
        DB::table('products')->insert($param);
        $param = [
            'name' => 'ショルダーバッグ',
            'img' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Purse+fashion+pocket.jpg',
            'price' => '3500',
            'detail' => 'おしゃれなショルダーバッグ',
            'condition_id' => '3',
        ];
        DB::table('products')->insert($param);
        $param = [
            'name' => 'タンブラー',
            'img' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Tumbler+souvenir.jpg',
            'price' => '500',
            'detail' => '使いやすいタンブラー',
            'condition_id' => '4',
        ];
        DB::table('products')->insert($param);
        $param = [
            'name' => 'コーヒーミル',
            'img' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Waitress+with+Coffee+Grinder.jpg',
            'price' => '4000',
            'detail' => '手動のコーヒーミル',
            'condition_id' => '1',
        ];
        DB::table('products')->insert($param);
        $param = [
            'name' => 'メイクセット',
            'img' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Tumbler+souvenir.jpg',
            'price' => '2500',
            'detail' => '便利なメイクアップセット',
            'condition_id' => '2',
        ];
        DB::table('products')->insert($param);
    }
}
