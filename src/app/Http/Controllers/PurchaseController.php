<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Order;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\PurchaseRequest;
use Stripe\Stripe;
use Stripe\Checkout\Session;



class PurchaseController extends Controller
{
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
        $product = Product::findOrFail($id);
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        $paymentMethods = ['card'];
        if ($request->method === 'コンビニ払い') {
            $paymentMethods[] = 'konbini';
        }
        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => $paymentMethods,
            'line_items' => [[
            'price_data' => [
                'currency' => 'jpy',
                'product_data' => [
                    'name' => $product->name,
                ],
                'unit_amount' => $product->price,
            ],
            'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => url('/'),
            'metadata' => [
                'product_id' => $product->id,
                'user_id' => auth()->id(),
                'payment_method' => $request->method,
                'post' => $request->post,
                'address' => $request->address,
                'building' => $request->building,
            ]
        ]);

        return redirect($session->url);
    }

    public function success(Request $request)
    {
        $sessionId = $request->query('session_id');
        if (!$sessionId) {
            return redirect('/')->with('error', '決済情報が見つかりませんでした。');
        }
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $session = \Stripe\Checkout\Session::retrieve($sessionId);
        } catch (\Exception $e) {
            return redirect('/')->with('error', '決済情報の取得に失敗しました。');
        }
        $productId = $session->metadata->product_id;
        $method = $session->metadata->payment_method;
        $post = $session->metadata->post;
        $address = $session->metadata->address;
        $building = $session->metadata->building ?? null;

        $userId = Auth::id();

        Order::create([
            'product_id' => $productId,
            'user_id' => $userId,
            'method' => $method,
            'post' => $post,
            'address' => $address,
            'building' => $building,
        ]);

        return redirect('/');
    }

    public function cancel()
    {
        return redirect('/');
    }
}
