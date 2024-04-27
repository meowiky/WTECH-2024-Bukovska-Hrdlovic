@extends('layouts.app')

@section('title', 'Products')

@section('content')
    <section id="products">
        <div id="products-header">
            <div></div>
            <div>
                <div>
                    <label for="include-planeter-select">Sort by</label>
                    <select id="include-planeter-select">
                        <option>Latest</option>
                        <option>Oldest</option>
                        <option>Cheapest</option>
                        <option>Most expensive</option>
                    </select>
                </div>
                <div><b id="product-count">{{ count($products) }}</b> Results Found</div>
            </div>
        </div>

        <div id="products-filter">
            <fieldset>
                <details open>
                    <summary>All Categories</summary>
                    <ul>
                        @foreach ($categories as $category)
                            <li>
                                <label>
                                    <input type="checkbox" name="categories[]" value="{{ $category->id }}" class="category-filter">
                                    {{ $category->name }} <span>({{ $category->products->count() }})</span>
                                </label>
                            </li>
                        @endforeach
                    </ul>
                </details>
                <details open>
                    <summary>Care Level</summary>
                    <ul>
                        @foreach ($careLevels as $id => $description)
                            <li>
                                <label>
                                    <input type="radio" name="care-level" value="{{ $id }}" class="care-level-filter"
                                        {{ isset($careLevelCounts[$id]) ? '' : 'disabled' }}>
                                    {{ $description }} <span>({{ $careLevelCounts[$id] ?? 0 }})</span>
                                </label>
                            </li>
                        @endforeach
                    </ul>
                </details>
            </fieldset>
        </div>

        <div id="products-tiles">
            @foreach ($products as $product)
                <a href="{{ url('/') }}">
                    <article class="big-tile radius">
                        <img class="default-image" src="{{ asset($product->image_path) }}" alt="{{ $product->name }}" />
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

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const categoryFilters = document.querySelectorAll('.category-filter');
            let lastCareLevel = null;
            const careLevelFilters = document.querySelectorAll('.care-level-filter');
            careLevelFilters.forEach(filter => {
                filter.addEventListener('click', function () {
                    if (this === lastCareLevel) {
                        this.checked = false;
                        lastCareLevel = null;
                    } else {
                        lastCareLevel = this;
                    }
                    updateProducts();
                });
            });

            function updateProducts() {
                let selectedCategories = Array.from(categoryFilters)
                    .filter(input => input.checked)
                    .map(input => input.value);

                let selectedCareLevel = lastCareLevel ? lastCareLevel.value : null;

                const queryParams = new URLSearchParams();
                selectedCategories.forEach(cat => queryParams.append('categories[]', cat));
                if (selectedCareLevel) {
                    queryParams.append('careLevel', selectedCareLevel);
                }

                const queryString = queryParams.toString();

                fetch(`/filter-products?${queryString}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('products-tiles').innerHTML = data.html;
                        document.getElementById('product-count').textContent = data.count;
                    })
                    .catch(error => console.error('Error loading the products:', error));
            }

            categoryFilters.forEach(filter => filter.addEventListener('change', updateProducts));
        });
    </script>

@endpush
