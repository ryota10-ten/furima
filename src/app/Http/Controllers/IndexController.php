<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index()
    {
        $products = Product::all();
        if (Auth::check())
        {
            $user = Auth::user();
            $favorites = $user->favoriteProducts;
        }

        return view('index',compact('products','favorites'));
    }
}
