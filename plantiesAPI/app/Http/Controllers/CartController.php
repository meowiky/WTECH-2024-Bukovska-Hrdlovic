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
        
        if (Auth::check()) {
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

        } else {
            // User is not authenticated, use session to store cart
            $cartItems = session()->get('cartItems', collect());
            $product = Product::findOrFail($request->product_id);
            $existingCartItem = $cartItems->where('product_id', $request->product_id)->first();
            if ($existingCartItem) {
                // Increment the quantity of the existing product
                $existingCartItem['quantity'] += $request->quantity;
            } else {
                // Add the new product to the cart
                $subtotal = (float)$product->price * (int)$request->quantity;
                $cartItem = [
                    'product_id' => $product->id,
                    'quantity' => (int)$request->quantity,
                    'name' => $product->name,
                    'price' => (float)$product->price,
                    'image_path' => $product->image_path,
                    'subtotal'=> $subtotal,
                ];
                $cartItems->push($cartItem);
            }
            session()->put('cartItems', $cartItems);
        }
        Log::info('adding to cart');

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Product added to cart']);
        }

        return back()->with('success', 'Product added to cart');
    }
}

