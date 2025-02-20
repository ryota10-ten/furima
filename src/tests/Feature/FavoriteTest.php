<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Favorite;

class FavoriteTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_like_a_product()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($user)->post("/item/{$product->id}/like", [
            'favorite' => true,
        ]);

        $this->assertDatabaseHas('favorites', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $response->assertRedirect("/item/{$product->id}");
    }

    public function test_liked_icon_changes_color()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $product = Product::factory()->create();

        Favorite::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $response = $this->get("/item/{$product->id}");

        $response->assertSee('checked'); // `checked` があればアイコンの色が変わっている
    }

    public function test_user_can_unlike_a_product()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $favorite = Favorite::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $response = $this->actingAs($user)->post("/item/{$product->id}/like", [
            'favorite' => false,
        ]);

        $this->assertDatabaseMissing('favorites', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
        $response->assertRedirect("/item/{$product->id}");
    }
}
