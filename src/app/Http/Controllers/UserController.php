<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\LoginRequest;


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
        $profile = $request->session()->get('profile');
        return view ('profile',compact('profile'));
    }

    public function add(ProfileRequest $profileRequest, AddressRequest $addressRequest)
    {
        $icon = null;
        if ($profileRequest->hasFile('icon')) {
            $icon = $profileRequest->file('icon')->store('icons', 'public');
        }

        Profile::updateOrCreate(
            ['email' => $addressRequest['email']],
            [
                'name'      => $addressRequest['name'],
                'icon' => $icon,
                'address'   => $addressRequest['address'],
                'password' =>$addressRequest['password'],
                'email' => $addressRequest['email'],
                'post' => $addressRequest['post'],
                'building' => $addressRequest['building'],
            ]);
        return view ('index');
    }
}
