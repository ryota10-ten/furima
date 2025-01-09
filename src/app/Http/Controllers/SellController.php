<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Condition;
use App\Models\Product;
use App\Models\User;
use App\Http\Requests\ExhibitionRequest;
use Illuminate\Support\Facades\Auth;

class SellController extends Controller
{
    public function sell()
    {
        $categories = Category::all();
        $conditions = Condition::all();
        return view('sell',compact('categories','conditions'));
    }

    public function store(ExhibitionRequest $request)
    {
        $img = $request->file('img')->store('imgs', 'public');
        $item = $request->all();
        $selectedCategories = $request->input('category');
        $item = Product::create([
            'name' => $request->input('name'),
            'img' => $img,
            'price' => $request->input('price'),
            'detail' => $request->input('detail'),
            'condition_id' => $request->input('condition_id'),
        ]);

        $item->categories()->attach($selectedCategories);
        $user = Auth::user();
        $item->users()->attach($user->id);
        $favorites = $user->favoriteProducts;
        $userId = Auth::id();
        $products = Product::with('orders')->whereDoesntHave
            ('users', function ($query) use ($userId)
            {
                $query->where('user_id', $userId);
            })->get();
        return view('index',compact('products','favorites'));
    }
}
