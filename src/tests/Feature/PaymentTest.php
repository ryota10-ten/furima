<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_payment_method_is_saved_in_session()
{
    $user = User::factory()->create();
    $product = Product::factory()->create();

    $selectedMethod = 'カード払い';

    $response = $this->actingAs($user)->post(route('purchase.method', ['id' => $product->id]), [
        'method' => $selectedMethod,
    ]);

    $this->assertEquals($selectedMethod, session('selectedMethod'));
    $response->assertRedirect(route('purchase.show', ['id' => $product->id]));
}
}
