<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrdersDetail;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Session;


class CheckoutController extends Controller
{
    
    public function showCheckoutPage(Request $request): View
    {
        if (Auth::check()) {
        $user = $request->user();
        $cart = Auth::user()->cart()->first();
        $cartItems = $cart->products()->get();
        $totalPrice = 0;
        foreach ($cartItems as $product) {
            $totalPrice += $product->price * $product->pivot->quantity;
        }
        return view('checkout', compact('cartItems', 'totalPrice', 'user'));
        } else {
            $cartItems = session()->get('cartItems');
            $totalPrice = 0;
            foreach ($cartItems as $product) {
                $totalPrice += (float)$product['price'] * (float)$product['quantity'];
            }
            return view('checkout', compact('cartItems', 'totalPrice'));
        }
    }

    public function process(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'street_number' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'postal_code' => 'required|string|max:255'
        ]);
        if (Auth::check()) {
            $cart = Auth::user()->cart()->first();
            $cartItems = $cart->products()->get();
            $totalPrice = 0;
            foreach ($cartItems as $product) {
                $totalPrice += $product->price * $product->pivot->quantity;
            }
            $order = Order::create([
                'user_id' => $cart['user_id'],
                'status' => 'active',
                'total_price' => $totalPrice
            ]);
            foreach ($cartItems as $productData) {
                OrdersDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $productData->id,
                    'quantity' => $productData->pivot->quantity
                ]);
                // Update product stock quantity
                $product = Product::find($productData->id);
                $product->stock_quantity -= $productData->pivot->quantity;
                $product->number_sold += $productData->pivot->quantity;
                $product->save();
            }
            $payment = Payment::create([
                'order_id' => $order->id,
                'payment_method' => $request['payment_method'],
                'amount' => $totalPrice
            ]);
            $cart -> delete();
        } else {
            $cartItems = session()->get('cartItems');
            $totalPrice = 0;
            foreach ($cartItems as $product) {
                $totalPrice += (float)$product['price'] * (float)$product['quantity'];
            }
            $order = Order::create([
                'user_id' => 1,
                'status' => 'active',
                'total_price' => $totalPrice
            ]);
            foreach ($cartItems as $productData) {
                OrdersDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $productData['product_id'],
                    'quantity' => (float)$productData['quantity']
                ]);
                // Update product stock quantity
                $product = Product::find($productData['product_id']);
                $product->stock_quantity -= (float)$productData['quantity'];
                $product->number_sold += (float)$productData['quantity'];
                $product->save();
            }
            $payment = Payment::create([
                'order_id' => $order->id,
                'payment_method' => $request['payment_method'],
                'amount' => $totalPrice
            ]);
            Session::flush();
        }
        return redirect('/')->with('success', 'Order placed successfully!');
    }
}