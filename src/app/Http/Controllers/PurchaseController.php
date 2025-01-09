<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Order;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\PurchaseRequest;


class PurchaseController extends Controller
{
    public function purchase()
    {
        return view('purchase');
    }

    public function buy(Request $request,$id)
    {
        $user = Auth::user();
        $product = Product::findOrFail($id);
        $selectedMethod = null;
        $address = null;

        return view('purchase',compact('user','product','selectedMethod','address'));
    }

    public function updateMethod(Request $request, $id)
    {
        $request->session()->put('selectedMethod', $request->input('method'));

        return redirect('/purchase/'. $id);
    }

    public function show(Request $request, $id)
    {
        $user = Auth::user();
        $product = Product::findOrFail($id);
        $selectedMethod = $request->session()->get('selectedMethod');
        $address = $request->session()->get('address', [
            'post' => $user->post,
            'address' => $user->address,
            'building' => $user->building,
        ]);

        return view('purchase', compact('user', 'product', 'selectedMethod','address'));
    }

    public function update(AddressRequest $request, $id)
    {
        $request->session()->put('address', [
            'post' => $request->input('post'),
            'address' => $request->input('address'),
            'building' => $request->input('building'),
        ]);

        return redirect('/purchase/'. $id);
    }

    public function edit($id)
    {
        $user = Auth::user();
        $product = Product::findOrFail($id);

        return view ('address', compact('user','product'));
    }

    public function fix(PurchaseRequest $request, $id)
    {
        Order::create([
            'product_id' => $request->product_id,
            'user_id' => auth()->id(),
            'method' => $request->method,
            'post' => $request->post,
            'address' => $request->address,
            'building' => $request->building,
        ]);
        $user = Auth::user();
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
