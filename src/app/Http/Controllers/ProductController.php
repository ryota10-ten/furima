<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Favorite;
use App\Http\Requests\CommentRequest;

class ProductController extends Controller
{
    public function show($id)
    {
        $product = Product::with(['favorites','comments'])->findOrFail($id);
        $categories = $product->categories;
        $condition = $product->condition;
        $commentCount = $product->comments->count();
        $favoriteCount = $product->favorites->count();

        return view('item', compact('product','condition','categories','commentCount','favoriteCount'));
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

    public function favorite(Request $request, $id)
    {
        $user = Auth::user();

        $favorite =Favorite::where('user_id', $user->id)->where('product_id', $id)->first();
        if ($request->input('favorite'))
        {
            if (!$favorite)
            {
                Favorite::create([
                    'user_id' => $user->id,
                    'product_id' => $id,
                ]);
            }
        }else {
            if ($favorite)
            {
                $favorite->delete();
            }
        }
        return redirect()->route('item.show', ['id' => $id]);
    }
}
