<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\ProfileRequest;


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

    public function add()
    {
        return view('profile');
    }

    public function store(RegisterRequest $request)
    {
        $profile = $request->all();

        return view ('profile',compact('profile'));
    }

    public function create(ProfileRequest $profilerequest, AddressRequest $addressrequest)
    {
        $icon = null;
        if ($profileRequest->hasFile('icon')) {
            $icon = $profileRequest->file('icon')->store('icons', 'public');
        }

        Profile::updateOrCreate(
            ['email' => $addressData['email']], 
            [
                'name'      => $addressData['name'],
                'icon' => $icon,
                'address'   => $addressData['address'],
            ]);
        return view('index');
    }
}
