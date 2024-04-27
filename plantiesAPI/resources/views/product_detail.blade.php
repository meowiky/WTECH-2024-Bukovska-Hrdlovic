@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <section class="green">
        <h1>{{ $product->name }}</h1>
    </section>

    <section id="shop-detail">
        <div class="gallery">
            <div>
                <img class="default-image" src="{{ asset($product->image_path) }}" alt="{{ $product->name }}" />
            </div>
        </div>
        <div class="detail">
            <h2>{{ $product->name }}</h2>
            <span>${{ number_format($product->price, 2) }}</span>
            <p>{{ $product->info }}</p>
            <form action="{{ route('cart.add') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}" />
                <fieldset>
                    <div class="shop-fieldset-actions">
                        <button type="submit" class="wide">ADD TO CART</button>
                        <div>
                            <label>Quantity</label>
                            <input type="number" name="quantity" min="1" value="1"/>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </section>
@endsection
