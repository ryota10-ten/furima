<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;

class AddressTest extends TestCase
{
    use RefreshDatabase;

    public function test_shipping_address_is_saved_and_reflected_on_purchase_page()
    {
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $product = Product::factory()->create();

        $response = $this->post(route('purchase.address.update', ['id' => $product->id]), [
            'post' => '123-4567',
            'address' => 'Tokyo, Shibuya, 1-1-1',
            'building' => 'Shibuya Mansion 101',
        ]);

        session(['address' => [
            'post' => '123-4567',
            'address' => 'Tokyo, Shibuya, 1-1-1',
            'building' => 'Shibuya Mansion 101',
        ]]);

        $response = $this->get(route('purchase.show', ['id' => $product->id]));

        $response->assertSee('〒123-4567');
        $response->assertSee('Tokyo, Shibuya, 1-1-1');
        $response->assertSee('Shibuya Mansion 101');
    }
}
