@extends('layouts.app')

@section('content')
<section class="green">
    <h1>Shopping Cart</h1>
</section>
<section id="cart">
    @if (count($cartItems) > 0)

        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cartItems as $product)
                @if (auth()->check())
                <tr>
                        <td>{{ $product->name }}</td>
                        <td>${{ $product->price }}</td>
                        <td>
                        <div class="quantity-controls">
                                <form action="{{ route('cartpage.incrementQuantity', ['product' => $product->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-quantity" data-action="increment">+</button>
                                </form> 
                                <span class="quantity">{{ $product->pivot->quantity }}</span>
                                <form action="{{ route('cartpage.decrementQuantity', ['product' => $product->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-quantity" data-action="decrement">-</button>
                                </form>
                        </div>  
                        </td>
                        <td>${{ $product->price * $product->pivot->quantity }}</td>
                        <td>
                            <form action="{{ route('cartpage.remove', ['product' => $product->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-remove">Remove</button>
                            </form>
                        </td>
                    </tr>
                @else
                    <tr>
                        <td>{{ $product['name'] }}</td>
                        <td>${{ $product['price'] }}</td>
                        <td>
                        <div class="quantity-controls">
                                <form action="{{ route('cartpage.incrementQuantity', ['product' => $product['product_id']]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-quantity" data-action="increment">+</button>
                                </form> 
                                <span class="quantity">{{ $product['quantity'] }}</span>
                                <form action="{{ route('cartpage.decrementQuantity', ['product' => $product['product_id']]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-quantity" data-action="decrement">-</button>
                                </form>
                        </div>  
                        </td>
                        <td>${{ $product['price'] * $product['quantity'] }}</td>
                        <td>
                            <form action="{{ route('cartpage.remove', ['product' => $product['product_id']]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-remove">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endif
                @endforeach
                <tr>
                    <td colspan="4"><strong>Total</strong></td>
                    <td>${{ $totalPrice }}</td>
                </tr>
            </tbody>
        </table>
        <form action="{{ route('checkout') }}" method="GET">
            <button type="submit" class="btn-checkout-cart">Proceed to Checkout</button>
        </form>
    @else
        <p>Your shopping cart is empty.</p>
    @endif
</section>
@endsection