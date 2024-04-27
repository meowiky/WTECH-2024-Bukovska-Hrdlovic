<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.header', function ($view) {
            $cartItems = collect([]);
            $totalPrice = 0.00;

            if (auth()->check()) {
                $cart = auth()->user()->cart()->with('products')->first();

                if ($cart) {
                    $cartItems = $cart->products->map(function ($product) {
                        $subtotal = $product->price * $product->pivot->quantity;
                        return [
                            'name' => $product->name,
                            'quantity' => $product->pivot->quantity,
                            'price' => $product->price,
                            'subtotal' => $subtotal,
                            'image_path' => $product->image_path,
                        ];
                    });

                    $totalPrice = $cartItems->sum('subtotal');
                }
            }

        $view->with(compact('cartItems', 'totalPrice'));
    });
    }
}
