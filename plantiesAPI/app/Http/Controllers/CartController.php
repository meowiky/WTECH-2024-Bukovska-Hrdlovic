<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = Auth::user()->cart()->firstOrCreate();

        $product = Product::findOrFail($request->product_id);

        $cartItem = $cart->products()->where('product_id', $product->id)->first();

        if ($cartItem) {
            $cart->products()->updateExistingPivot($product->id, [
                'quantity' => $cartItem->pivot->quantity + $request->quantity
            ]);
        } else {
            $cart->products()->attach($product->id, ['quantity' => $request->quantity]);
        }

        Log::info('adding to cart');

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Product added to cart']);
        }

        return back()->with('success', 'Product added to cart');
    }
}

