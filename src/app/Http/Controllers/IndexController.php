<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index()
    {
        if (Auth::check())
        {
            $user = Auth::user();
            $userId = Auth::id();
            $favorites = $user->favoriteProducts;
            $userId = Auth::id();
            $products = Product::with('orders')->whereDoesntHave
            ('users', function ($query) use ($userId)
            {
                $query->where('user_id', $userId);
            })->get();

        }else{
            $favorites = null;
            $products = Product::with('orders')->get();
        }

        return view('index',compact('products','favorites'));
    }

    public function search(Request $request)
    {
        if (Auth::check())
        {
            $user = Auth::user();
            $userId = Auth::id();
            $favorites = $user->favoriteProducts;
            $userId = Auth::id();
            $products = Product::with('orders')->whereDoesntHave
            ('users', function ($query) use ($userId)
            {
                $query->where('user_id', $userId);
            })->KeywordSearch($request->keyword)->get();

        }else{
            $favorites = null;
            $products = Product::with('orders')->KeywordSearch($request->keyword)->get();
        }

        return view('index',compact('products','favorites'));
    }
}
