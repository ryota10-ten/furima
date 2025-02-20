<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\Favorite;
use App\Models\Listing;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MylistTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_liked_products_are_displayed_in_my_list()
    {
        $user = User::factory()->create();

        $likedProduct = Product::factory()->create(['name' => 'お気に入り商品']);
        $unlikedProduct = Product::factory()->create(['name' => '未登録商品']);

        Favorite::create([
            'user_id' => $user->id,
            'product_id' => $likedProduct->id,
        ]);

        $response = $this->actingAs($user)->get('/');
        $myListHtml = $response->viewData('favorites');
        $response->assertSee('お気に入り商品');
        $this->assertStringNotContainsString('未登録商品', $myListHtml);
    }

    public function test_nothing_is_displayed_if_not_logged_in()
    {
        $response = $this->get('/');

        $response->assertSee('ログインしてください');
        $response->assertDontSee('商品一覧');
    }

    public function test_user_cannot_see_their_own_products_in_my_list()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $product = Product::factory()->create();
        Listing::create([
            'user_id' => $user->id,
            'product_id' => $product->id
        ]);

        $response = $this->get('/');
        $response->assertDontSee($product->name);
    }

    public function test_displays_sold_label_for_purchased_products()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        Order::create([
            'method' => 'voluptas',
            'post' => 'porro',
            'address' => 'aut',
            'user_id' => $user->id,
            'product_id' => $product->id
        ]);

        $response = $this->get('/');

        $response->assertSee('sold');
    }
}
