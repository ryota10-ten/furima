<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Factories\ProductFactory;
use Database\Factories\OrderFactory;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Listing;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_displays_all_products_on_the_list_page()
    {

        Product::factory()->count(3)->create();

        $response = $this->get('/');

        $response->assertStatus(200);

        $products = Product::all();
        foreach ($products as $product) {
            $response->assertSee($product->name);
        }
    }

    public function test_displays_sold_label_for_purchased_products()
    {
    
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $order = Order::create([
            'method' => 'voluptas',
            'post' => 'porro',
            'address' => 'aut',
            'user_id' => $user->id,
            'product_id' => $product->id
        ]);

        $response = $this->get('/');

        $response->assertSee('sold');
    }

    public function it_does_not_display_user_own_products()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $product = Product::factory()->create();
        $listing = Listing::create([
            'user_id' => $user->id,
            'product_id' => $product->id
        ]);

        $response = $this->get('/');
        $response->assertDontSee($product->name);
    }
}
