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
                            <button class="icon"><img src="{{ asset('assets/shop.svg') }}" /></button>
                        </div>
                    </article>
                </a>
            @endforeach
        </div>
    </section>
@endsection

