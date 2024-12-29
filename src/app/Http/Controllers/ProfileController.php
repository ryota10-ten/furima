<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\Listing;


class ProfileController extends Controller
{
    public function mypage()
    {
        $products = Listing::all();

        return view ('mypage',compact('products'));
    }
}
