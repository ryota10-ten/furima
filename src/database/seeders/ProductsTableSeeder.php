<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        // 商品データ配列
        $products = [
            [
                'name' => '腕時計',
                'img_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Armani+Mens+Clock.jpg',
                'price' => 15000,
                'detail' => 'スタイリッシュなデザインのメンズ腕時計',
                'condition_id' => 1,
            ],
            [
                'name' => 'HDD',
                'img_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/HDD+Hard+Disk.jpg',
                'price' => 5000,
                'detail' => '高速で信頼性の高いハードディスク',
                'condition_id' => 2,
            ],
            [
                'name' => '玉ねぎ3束',
                'img_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/iLoveIMG+d.jpg',
                'price' => 300,
                'detail' => '新鮮な玉ねぎ3束のセット',
                'condition_id' => 3,
            ],
            [
                'name' => '革靴',
                'img_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Leather+Shoes+Product+Photo.jpg',
                'price' => 4000,
                'detail' => 'クラシックなデザインの革靴',
                'condition_id' => 3,
            ],
            [
                'name' => 'ノートPC',
                'img_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Living+Room+Laptop.jpg',
                'price' => 45000,
                'detail' => '高性能なノートパソコン',
                'condition_id' => 1,
            ],
            [
                'name' => 'マイク',
                'img_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Music+Mic+4632231.jpg',
                'price' => 8000,
                'detail' => '高音質のレコーディング用マイク',
                'condition_id' => 2,
            ],
            [
                'name' => 'ショルダーバッグ',
                'img_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Purse+fashion+pocket.jpg',
                'price' => 3500,
                'detail' => 'おしゃれなショルダーバッグ',
                'condition_id' => 3,
            ],
            [
                'name' => 'タンブラー',
                'img_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Tumbler+souvenir.jpg',
                'price' => 500,
                'detail' => '使いやすいタンブラー',
                'condition_id' => 4,
            ],
            [
                'name' => 'コーヒーミル',
                'img_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Waitress+with+Coffee+Grinder.jpg',
                'price' => 4000,
                'detail' => '手動のコーヒーミル',
                'condition_id' => 1,
            ],
            [
                'name' => 'メイクセット',
                'img_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/%E5%A4%96%E5%87%BA%E3%83%A1%E3%82%A4%E3%82%AF%E3%82%A2%E3%83%83%E3%83%95%E3%82%9A%E3%82%BB%E3%83%83%E3%83%88.jpg',
                'price' => 2500,
                'detail' => '便利なメイクアップセット',
                'condition_id' => 2,
            ],
        ];

        foreach ($products as $product) {
            $imageContent = file_get_contents($product['img_url']);
            $imageName = 'imgs/' . Str::random(10) . '.jpg'; 
            Storage::disk('public')->put($imageName, $imageContent);

            DB::table('products')->insert([
                'name' => $product['name'],
                'img' => $imageName, 
                'price' => $product['price'],
                'detail' => $product['detail'],
                'condition_id' => $product['condition_id'],
            ]);
        }
    }
}
