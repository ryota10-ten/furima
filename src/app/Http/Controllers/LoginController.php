<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;

class LoginController extends Controller
{
    use \Illuminate\Foundation\Auth\AuthenticatesUsers;

    public function login()
    {
        return view('login');
    }

    protected function redirectTo()
    {
        return '/'; 
    }

    protected function credentials(LoginRequest $request)
    {
        return [
            'email' => $request->get('email'),
            'password' => $request->get('password'),
            'is_active' => 1, // 例: アクティブなユーザーのみログイン可能
        ];
    }
}
