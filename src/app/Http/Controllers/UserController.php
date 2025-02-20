<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class UserController extends Controller
{

    public function login()
    {
        return view('login');
    }

    public function register()
    {
        return view('register');
    }

    public function store(RegisterRequest $request)
    {
        $profile = User::create([
            'name'      => $request->input('name'),
            'password'  => Hash::make($request->input('password')),
            'email'     => $request->input('email'),
        ]);
        Auth::login($profile);
        event(new Registered($profile));

        return redirect()->route('verification.notice');
    }

    public function edit(Request $request)
    {
        $user = Auth::user();
        $profile = User::where('email', $user->email)->first();
        return view ('profile',compact('profile'));
    }

    public function add(ProfileRequest $profileRequest, AddressRequest $addressRequest)
    {
        $icon = null;
        if ($profileRequest->hasFile('icon')) {
            $icon = $profileRequest->file('icon')->store('icons', 'public');
        }
        $products =  Product::all();
        $user = Auth::user();
        $user->update([
            'name'      => $addressRequest->input('name'),
            'icon'      => $icon,
            'address'   => $addressRequest->input('address'),
            'post'      => $addressRequest->input('post'),
            'building'  => $addressRequest->input('building'),
        ]);

        return redirect('/');
    }

}