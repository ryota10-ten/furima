<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Order;
use App\Http\Requests\AddressRequest;


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

    public function fix(Request $request, $id)
    {
        Order::create([
            'product_id' => $request->product_id,
            'user_id' => auth()->id(),
            'method' => $request->method,
            'post' => $request->post,
            'address' => $request->address,
            'building' => $request->building,
        ]);
        $products = Product::with('orders')->get();
        $user = Auth::user();
        $favorites = $user->favoriteProducts;
        
        return view('index',compact('products','favorites'));
    }

}
