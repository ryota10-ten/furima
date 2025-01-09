<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index()
    {
        $products = Product::with('orders')->get();
        if (Auth::check())
        {
            $user = Auth::user();
            $favorites = $user->favoriteProducts;
        }else{
            $favorites = null;
        }
        return view('index',compact('products','favorites'));
    }
}
