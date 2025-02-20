<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\VerifyEmail;

class RegisterTest extends TestCase
{
    
    use RefreshDatabase;

    public function test_displays_the_registration_page()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
    }

    public function test_displays_error_when_name_is_empty()
    {
        $response = $this->post('/mypage/profile/', [
            'name' => '',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors(['name' => 'お名前を入力してください']);
    }

    public function test_displays_error_when_email_is_empty()
    {
        $response = $this->post('/mypage/profile/', [
            'name' => 'Test User',
            'email' => '',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors(['email' => 'メールアドレスを入力してください']);
    }

    public function test_displays_error_when_password_is_empty()
    {
        $response = $this->post('/mypage/profile/', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => '',
            'password_confirmation' => '',
        ]);

        $response->assertSessionHasErrors(['password' => 'パスワードを入力してください']);
    }

    public function test_displays_error_when_password_is_less_than_8_characters()
    {
        $response = $this->post('/mypage/profile/', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'short',
            'password_confirmation' => 'short',
        ]);

        $response->assertSessionHasErrors(['password' => 'パスワードは8文字以上で入力してください']);
    }

    public function test_displays_error_when_password_confirmation_does_not_match()
    {
        $response = $this->post('/mypage/profile/', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'differentpassword',
        ]);

        $response->assertSessionHasErrors(['password' => 'パスワードと一致しません']);
    }

    public function test_registers_user_successfully_when_all_inputs_are_valid()
    {
        $response = $this->post('/mypage/profile/', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
        ]);

        $response->assertRedirect('/email/verify');
    }

    public function test_verifies_email_and_redirects_to_profile()
    {
        $user = User::factory()->create([
            'email_verified_at' => null, // 未認証の状態
        ]);
        
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        $response = $this->actingAs($user)->get($verificationUrl);

        $response->assertRedirect('/mypage/profile/');

        $this->assertNotNull($user->fresh()->email_verified_at);
    }
}