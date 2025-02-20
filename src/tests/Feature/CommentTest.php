<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Comment;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_logged_in_user_can_post_a_comment()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($user)->post('/comments', [
            'product_id' => $product->id,
            'comment' => 'これはテストコメントです。',
        ]);

        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'comment' => 'これはテストコメントです。',
        ]);
    }

    public function test_guest_cannot_post_a_comment()
    {
        $product = Product::factory()->create();

        $response = $this->post('/comments', [
            'product_id' => $product->id,
            'comment' => 'テストコメント',
        ]);

        $response->assertRedirect('/login');
    }

    public function test_comment_must_not_be_empty()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($user)->post('/comments', [
            'product_id' => $product->id,
            'comment' => '',
        ]);

        $response->assertSessionHasErrors('comment');
    }

    public function test_comment_must_not_exceed_255_characters()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $longComment = str_repeat('あ', 256);

        $response = $this->actingAs($user)->post('/comments', [
            'product_id' => $product->id,
            'comment' => $longComment,
        ]);

        $response->assertSessionHasErrors('comment');
    }
}
