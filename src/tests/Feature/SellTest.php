<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class SellTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_sell_product()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $categories = Category::factory()->count(3)->create();
        $categoryIds = $categories->pluck('id')->toArray();

        $file = UploadedFile::fake()->image('product.jpg');

        $response = $this->post('/sell', [
            'name' => 'テスト商品',
            'brand' => 'テストブランド',
            'price' => 1000,
            'detail' => 'これはテスト商品の説明です。',
            'condition_id' => 1,
            'category' => $categoryIds,
            'img' => $file,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name', 'brand', 'detail', 'img', 'price', 'condition_id', 'category']);
        
        $this->assertDatabaseHas('products', [
            'name' => 'テスト商品',
            'brand' => 'テストブランド',
            'price' => 1000,
            'detail' => 'これはテスト商品の説明です。',
            'condition_id' => 1,
        ]);

        $product = Product::where('name', 'テスト商品')->first();

        foreach ($categories as $category)
        {
            $this->assertDatabaseHas('category_product', [
                'category_id' => $category->id,
                'product_id' => $product->id,
            ]);
        }
    }
}
