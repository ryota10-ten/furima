<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;
use App\Models\Product;


class LoginController extends Controller
{

    public function index()
    {
        return view('login');
    }

    public function login(LoginRequest $request)
    {
        if(Auth::attempt($request->only('email','password'))){
            $user = Auth::user();
            if (!$user->hasVerifiedEmail()) {
                return redirect()->route('verification.notice')->withErrors([
                    'email' => 'メール認証が完了していません。認証メールを確認してください。',
                ]);
            }
            \Log::info('ログイン成功');
            $request->session()->regenerate();
            return redirect()->intended('/');
        } else {
            \Log::info('ログイン失敗', $request->only('email', 'password'));

            return back()->withErrors([
                'email' => 'ログイン情報が登録されていません',
                'password' => 'ログイン情報が登録されていません',
            ]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        return redirect('/');
    }

}
