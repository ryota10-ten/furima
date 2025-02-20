<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;


class ProfileEditTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_profile_page_displays_correct_initial_values()
    {

        $user = User::factory()->create([
            'icon' => 'profile_images/test_user.jpg',
            'name' => 'Test User',
            'post' => '123-4567',
            'address' => '東京都渋谷区テスト1-2-3',
            'building' => 'テストビル101',
        ]);

        $response = $this->actingAs($user)->get('/mypage/profile');

        $response->assertSee('http://127.0.0.1:8000/storage/profile_images/test_user.jpg');
        $response->assertSee('Test User');
        $response->assertSee('123-4567');
        $response->assertSee('東京都渋谷区テスト1-2-3');
        $response->assertSee('テストビル101');
    }
}

