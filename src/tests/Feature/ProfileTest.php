<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Listing;
use App\Models\Order;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_profile_page_displays_correct_information()
    {

        $user = User::factory()->create([
            'name' => 'Test User',
            'icon' => 'profile_images/test_user.jpg',
            'email' =>'test@exmple.com'
        ]);
        
        $listingProduct = Product::factory()->create();
        Listing::create([
            'user_id' => $user->id,
            'product_id' => $listingProduct->id,
        ]);

        $orderedProduct = Product::factory()->create();
        Order::create([
            'user_id' => $user->id,
            'product_id' => $orderedProduct->id,
            'method' => 'credit_card',
            'post' => '1234',
            'address' => 'Tokyo',
        ]);

        $this->actingAs($user);
        $response = $this->get('/mypage');
        $response->assertSee('Test User');
        $response->assertSee('http://127.0.0.1:8000/storage/profile_images/test_user.jpg');

        $response->assertSee($listingProduct->name);
        $response->assertSee($orderedProduct->name);
    }
}
