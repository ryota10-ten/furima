<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Favorite;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_search_products_by_partial_match()
    {

        $matchingProduct = Product::factory()->create(['name' => 'テスト商品']);
        $nonMatchingProduct = Product::factory()->create(['name' => 'サンプルアイテム']);

        $response = $this->get('/search?keyword=テスト');

        $response->assertSee('テスト商品');

        $response->assertDontSee('サンプルアイテム');
    }

    public function search_query_is_retained_in_my_list()
    {
        $user = User::factory()->create();

        $matchingProduct = Product::factory()->create(['name' => '検索対象商品']);
        $nonMatchingProduct = Product::factory()->create(['name' => '検索対象外アイテム']);

        Favorite::create([
            'user_id' => $user->id,
            'product_id' => $matchingProduct->id,
        ]);

        $response = $this->actingAs($user)->get('/search?keyword=検索');

        $response->assertSee('検索対象商品');
        $response->assertDontSee('検索対象外アイテム');
    }
}
