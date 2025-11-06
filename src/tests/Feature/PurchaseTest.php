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
    protected $user;
    protected $product;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->product = Product::factory()->create();

        Stripe::setApiKey(config('services.stripe.secret'));

    }

    public function test_user_is_redirected_to_stripe_checkout()
    {
        $response = $this->actingAs($this->user)->post(route('purchase.fix', ['id' => $this->product->id]), [
            'method' => 'card',
            'post' => '1234',
            'address' => 'Tokyo',
        ]);
        $this->assertTrue($response->isRedirect(), 'Response is not a redirect');
        $redirectUrl = $response->headers->get('Location');
        $this->assertNotNull($redirectUrl, 'Redirect URL is null');
        $this->assertStringContainsString('https://checkout.stripe.com/c/pay/', $redirectUrl);
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
