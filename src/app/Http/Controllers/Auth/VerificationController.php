<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{
    /**
     * メール認証用のビューを表示
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        return view('auth.verify-email'); // メール認証ページを表示
    }

    /**
     * メール認証を処理
     *
     * @param \Illuminate\Foundation\Auth\EmailVerificationRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verify(EmailVerificationRequest $request)
    {
        $user = $request->user();
        if ($user->hasVerifiedEmail()) {
            return redirect('profile')->with('message', 'すでにメール認証が完了しています。');
        }
        $user->markEmailAsVerified();
        Auth::login($user);
        return redirect('/mypage/profile/');
    }

    /**
     * 認証メールの再送信
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resend(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', '認証メールを再送信しました。');
    }
}
