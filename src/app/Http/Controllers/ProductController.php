<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Category;
use App\Models\Comment;
use App\Http\Requests\CommentRequest;

class ProductController extends Controller
{
    public function item(){
        return view ('item');
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        $categories = $product->categories;
        $condition = $product->condition;

        $question = product::with('comments.user')->withCount('comments')->findOrFail($id);

        return view('item', compact('product','condition','categories','question'));
    }

    public function store(CommentRequest $request)
    {
        if (!auth()->check())
        {
            return back()->with('error', 'コメントを投稿するにはログインが必要です。');
        }
        Comment::create([
            'product_id' => $request->product_id,
            'comment' => $request->comment,
            'user_id' => auth()->id(),
        ]);

        return back();
    }
}
