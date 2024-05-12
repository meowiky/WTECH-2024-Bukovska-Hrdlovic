<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartPageController extends Controller
{

    public function showCartPage()

    {

        if (Auth::check()) {
        $cart = Cart::where('user_id', auth()->id())->first();
        if (!$cart) {
            $cartItems = [];
            return view('cart_page', compact('cartItems'));   
        }
        $cartItems = $cart->products()->get();
        $totalPrice = 0;
        foreach ($cartItems as $product) {
            $totalPrice += $product->price * $product->pivot->quantity;
        }
        } else {
            $cartItems = session()->get('cartItems');
            if (!$cartItems) {
                $cartItems = [];
                return view('cart_page', compact('cartItems'));   
            }
            $totalPrice = 0;
            foreach ($cartItems as $product) {
                $totalPrice += (float)$product['price'] * (float)$product['quantity'];
            }
        }
        return view('cart_page', compact('cartItems', 'totalPrice'));
    }

    public function remove(Request $request)
    {
        $productId = $request->input('product');
        if (Auth::check()) {
        $cart = Auth::user()->cart()->first();
        $cart->products()->detach($productId);
        }
        return redirect()->back()->with('success', 'Product removed from cart successfully.');
    }

    public function incrementQuantity(Request $request)
    {
        $productId = $request->input('product');
        if (Auth::check()) {
        $cart = Auth::user()->cart()->first();
        $cartItem = $cart->products()->find($productId);
        $cart->products()->updateExistingPivot($productId, [
            'quantity' => $cartItem->pivot->quantity + 1
        ]);
        }
        return redirect()->back()->with('success', 'Product quantity incremented successfully.');
        
    }

    public function decrementQuantity(Request $request)
    {
        $productId = $request->input('product');
        if (Auth::check()) {
        $cart = Auth::user()->cart()->first();
        $cartItem = $cart->products()->find($productId);

        if ($cartItem->pivot->quantity > 1) {
            $cart->products()->updateExistingPivot($productId, [
                'quantity' => $cartItem->pivot->quantity - 1
            ]);
            return redirect()->back()->with('success', 'Product quantity decremented successfully.');
        } else {
            return redirect()->back()->with('error', 'Cannot decrement quantity below 1.');
        }
        }
        return redirect()->back()->with('success', 'Product quantity decremented successfully.');
    }

}