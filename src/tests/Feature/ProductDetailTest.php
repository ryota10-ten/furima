<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Favorite;
use App\Models\Comment;
use App\Models\Category;
use App\Models\Condition;

class ProductDetailTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_detail_page_displays_all_required_information()
    {
        // 商品作成
        $product = Product::factory()->create([
            'name' => 'テスト商品',
            'price' => 5000,
            'detail' => 'これはテスト用の商品です。',
            'brand' => 'ブランド',
            'img' => 'Dt3qtiMLm6.jpg'
        ]);
        $user = User::factory()->create();

        // カテゴリ作成
        $category = Category::factory()->create();
        $product->categories()->attach($category->id);

        // 商品状態作成
        $condition = Condition::factory()->create();
        $product->condition()->associate($condition)->save();

        Favorite::factory()->create([
            'product_id' => $product->id,
            'user_id' => $user->id,
        ]);

        Comment::factory()->count(2)->create([
            'product_id' => $product->id,
            'user_id' => $user->id,
        ]);

        $response = $this->get("/item/{$product->id}");
        $response->assertSee('src="http://127.0.0.1:8000/storage/Dt3qtiMLm6.jpg"', false);
        $response->assertSeeText('テスト商品');
        $response->assertSeeText('5,000');
        $response->assertSeeText('これはテスト用の商品です。');
        $response->assertSeeText('ブランド');
        $response->assertSeeText($category->category);
        $response->assertSeeText($condition->condition);
        $response->assertSeeText('1');
        $response->assertSeeText('2');
    }

    public function test_multiple_categories_are_displayed()
    {
        $product = Product::factory()->create();

        $categories = Category::factory()->count(3)->create();
        $product->categories()->attach($categories->pluck('id'));

        $response = $this->get("/item/{$product->id}");

        foreach ($categories as $category) {
            $response->assertSee($category->category);
        }
    }


}
