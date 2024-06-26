@foreach ($products as $product)
    <a href="{{ route('product.show', ['id' => $product->id]) }}">
        <article class="big-tile radius">
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
