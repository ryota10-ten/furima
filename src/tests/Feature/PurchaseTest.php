<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\Order;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_is_redirected_to_stripe_checkout()
    {
        $mockSession = \Mockery::mock('overload:' . Session::class);
        $mockSession->shouldReceive('create')->once()->andReturn((object)[
            'url' => 'https://checkout.stripe.com/c/pay/cs_test_mockSession'
        ]);
        $this->app->instance(\Stripe\Checkout\Session::class, $mockSession);
        $user = User::factory()->create();
        $product = Product::factory()->create();
        config(['app.url' => 'https://checkout.stripe.com']);
        $response = $this->actingAs($user)->post(route('purchase.fix', ['id' => $product->id]), 
            [
                'method' => 'card',
                'post' => '1234',
                'address' => 'Tokyo',
                'user_id' => $user->id,
                'product_id' => $product->id
            ]
        );

        $response->assertRedirect('https://checkout.stripe.com/c/pay/cs_test_mockSession');
    }

    public function test_product_is_marked_as_sold_after_purchase()
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

    public function test_order_is_added_to_user_profile_after_purchase()
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

        $this->actingAs($user);
        $response = $this->get('/mypage');
        $response->assertSee($product->name);
        $response->assertSee('SOLD');
    }
}
