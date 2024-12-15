<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Category;
use App\Models\Comment;
use App\Http\Request\CommentRequest;

class ProductController extends Controller
{
    public function item(){
        return view ('item');
    }

    public function show($id)
    {
        $product = Product::with('condition')->findOrFail($id);
        $categoryIds = Category::all();

        $product->categories()->syncWithoutDetaching($categoryIds);
        $question = product::with('comments.profile')->withCount('comments')->findOrFail($id);

        return view('item', compact('product','categoryIds','question'));
    }

    public function store(CommentRequest $request)
    {
        if (!auth()->check())
        {
            return redirect()->route('login')->with('error', 'コメントを投稿するにはログインが必要です。');
        }
        
        Comment::create([
            'product_id' => $request->product_id,
            'comment' => $request->comment,
            'profile_id' => auth()->id(),
        ]);

        return back();
    }
}
