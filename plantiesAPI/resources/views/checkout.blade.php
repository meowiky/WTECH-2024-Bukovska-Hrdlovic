@extends('layouts.app')

@section('content')
<section class="green">
        <h1>Checkout</h1>
</section>
    <section>
    @if (auth()->check())
        <form id="billing-form" method="POST" action="{{ route('process_checkout') }}">
            @csrf
            @method('POST')
            <h3>Billing Address</h3>
            <div class="row">
                <div class="form-group">
                    <label>First Name:</label>
                    <input type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}">
                    @error('first_name')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Last Name:</label>
                    <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}">
                    @error('last_name')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label>Street Address:</label>
                <input type="text" name="street" value="{{ old('street', $user->street) }}">
                @error('street')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label>Street Number:</label>
                <input type="text" name="street_number" value="{{ old('street_number', $user->street_number) }}">
                @error('street_number')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label>City:</label>
                <input type="text" name="city" value="{{ old('city', $user->city) }}">
                @error('city')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label>State:</label>
                <input type="text" name="state" value="{{ old('state', $user->state) }}">
                @error('state')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="row">
                <div class="form-group">
                    <label>Country:</label>
                    <select name="country">
                        <option value="" disabled selected>Select Country</option>
                        <option value="SK" @if($user->country == 'SK') selected @endif>Slovakia</option>
                        <option value="CZ" @if($user->country == 'CZ') selected @endif>Czech republic</option>
                    </select>
                    @error('country')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="zip">ZIP Code:</label>
                    <input type="text" name="postal_code" value="{{ old('postal_code', $user->postal_code) }}">
                    @error('postal_code')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row">
            <div class="form-group">
                <label>Payment Method:</label>
                <select name="payment_method">
                    <option value="cash_on_delivery">Cash on Delivery</option>
                    <option value="card_payment">Card Payment</option>
                </select>
                @error('payment_method')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
            <section id="cart">
        @if (count($cartItems) > 0)
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cartItems as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>${{ $product->price }}</td>
                            <td>{{ $product->pivot->quantity }}</td>
                            <td>${{ $product->price * $product->pivot->quantity }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="3"><strong>Total</strong></td>
                        <td>${{ $totalPrice }}</td>
                    </tr>
                </tbody>
            </table>
        @else
            <p>Your shopping cart is empty.</p>
        @endif
    @else
    <form id="billing-form" method="POST" action="{{ route('process_checkout') }}">
            @csrf
            @method('POST')
            <h3>Billing Address</h3>
            <div class="row">
                <div class="form-group">
                    <label>First Name:</label>
                    <input type="text" name="first_name">
                    @error('first_name')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Last Name:</label>
                    <input type="text" name="last_name">
                    @error('last_name')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label>Street Address:</label>
                <input type="text" name="street">
                @error('street')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label>Street Number:</label>
                <input type="text" name="street_number">
                @error('street_number')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label>City:</label>
                <input type="text" name="city">
                @error('city')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label>State:</label>
                <input type="text" name="state">
                @error('state')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="row">
                <div class="form-group">
                    <label>Country:</label>
                    <select name="country">
                        <option value="" disabled selected>Select Country</option>
                        <option value="SK">Slovakia</option>
                        <option value="CZ">Czech republic</option>
                    </select>
                    @error('country')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="zip">ZIP Code:</label>
                    <input type="text" name="postal_code">
                    @error('postal_code')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row">
            <div class="form-group">
                <label>Payment Method:</label>
                <select name="payment_method">
                    <option value="cash_on_delivery">Cash on Delivery</option>
                    <option value="card_payment">Card Payment</option>
                </select>
                @error('payment_method')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
            <section id="cart">
        @if (count($cartItems) > 0)
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cartItems as $product)
                        <tr>
                            <td>{{ $product['name'] }}</td>
                            <td>${{ $product['price'] }}</td>
                            <td>{{ $product['quantity'] }}</td>
                            <td>${{ $product['price'] * $product['quantity'] }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="3"><strong>Total</strong></td>
                        <td>${{ $totalPrice }}</td>
                    </tr>
                </tbody>
            </table>
        @else
            <p>Your shopping cart is empty.</p>
        @endif
    @endif
    </section>
            <button type="submit" class="btn-checkout">Place Order</button>
        </form>
        
</section>
@endsection