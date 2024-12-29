<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;


class LoginController extends Controller
{

    public function index()
    {
        return view('login');
    }

    public function login(LoginRequest $request)
    {
        $user_info = $request ->only('email', 'password');
        if(Auth::attempt($user_info)){
            dd($user_info);
            $request->session()->regenerate();
            return redirect('/');
        }

        return back()->withErrors([
        'email' => '認証に失敗しました。',
        'password' => '認証に失敗しました。',
        ]);
    }

    protected function guard()
    {
        return Auth::guard();
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $products = Product::all();

        return view('index',compact('products'));
    }

}
