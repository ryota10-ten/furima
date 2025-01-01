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
        $profile = $request->input();
        $request->session()->put('profile', $profile);
        return view ('profile',compact('profile'));
    }

    public function edit(Request $request)
    {
        $user = Auth::user();
        $profile = User::where('email', $user->email)->first();
        if (!$profile){
            $profile = $request->session()->get('profile');
        }
        return view ('profile',compact('profile'));
    }

    public function add(ProfileRequest $profileRequest, AddressRequest $addressRequest)
    {
        $icon = null;
        if ($profileRequest->hasFile('icon')) {
            $icon = $profileRequest->file('icon')->store('icons', 'public');
        }

        if (Auth::check()) {
            $user = Auth::user();
            $user->update([
                'name'      => $addressRequest->input('name'),
                'icon'      => $icon,
                'address'   => $addressRequest->input('address'),
                'email'     => $addressRequest->input('email'),
                'post'      => $addressRequest->input('post'),
                'building'  => $addressRequest->input('building'),
            ]);
        }else {
            User::create([
                'name'      => $addressRequest->input('name'),
                'icon'      => $icon,
                'address'   => $addressRequest->input('address'),
                'password'  => Hash::make($addressRequest->input('password')),
                'email'     => $addressRequest->input('email'),
                'post'      => $addressRequest->input('post'),
                'building'  => $addressRequest->input('building'),
            ]);
        }

        $email = $addressRequest->input('email');
        $user = User::where('email', $email)->first();

        if ($user->first_login) {
            $user->update(['first_login' => false]);
        }

        $products =  Product::all();

        return view('index',compact('products'));
    }
}