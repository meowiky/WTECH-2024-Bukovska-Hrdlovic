@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <section class="green">
        <div class="header">
            <h1><span class="green">Recently Added</span> Plants</h1>
            <span><a href="{{ route('products') }}">SHOP ALL ></a></span>
        </div>
        <hr />
        <div class="tile-list large">
            @foreach ($recentProducts as $product)
                <a href="{{ route('product.show', ['id' => $product->id]) }}">
                    <article class="big-tile radius white">
                        <img class="default-image" src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" />
                        <div class="big-tile-content">
                            <div>
                                <span>{{ $product->name }}</span>
                                <span>${{ number_format($product->price, 2) }}</span>
                            </div>
                            <form action="{{ route('cart.add') }}" method="POST" style="display:inline;">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="icon"><img src="{{ asset('assets/shop.svg') }}" /></button>
                            </form>
                        </div>
                    </article>
                </a>
            @endforeach
        </div>
    </section>
@endsection

