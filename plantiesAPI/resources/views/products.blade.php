@extends('layouts.app')

@section('title', 'Products')

@section('content')
    <section class="green">
        <h1>Shop</h1>
    </section>
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
                <div><b id="product-count">{{ $products->total() }}</b> Results Found</div>
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
                                    <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                           class="category-filter"
                                        {{ in_array($category->id, request()->input('categories', [])) ? 'checked' : '' }}>
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
                                    <input type="radio" name="care-level" value="{{ $id }}"
                                           class="care-level-filter"
                                        {{ ($id == request()->input('careLevel')) ? 'checked' : '' }}
                                        {{ !isset($careLevelCounts[$id]) ? 'disabled' : '' }}>
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
                <a href="{{ route('product.show', ['id' => $product->id]) }}">
                    <article class="big-tile radius">
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
        <div class="pagination">
            {!! $products->links() !!}
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            bindEventListeners();
            setTimeout(function() {
                updateSortDropdown();
            }, 100);

        });

        function updateSortDropdown() {
            const urlParams = new URLSearchParams(window.location.search);
            const sort = urlParams.get('sort');
            const select = document.getElementById('include-planeter-select');
            if (sort && select) {
                select.value = sort;
            }
        }

        function bindEventListeners() {
            document.getElementById('include-planeter-select').addEventListener('change', () => updateProducts());
            document.querySelectorAll('.category-filter').forEach(filter => filter.addEventListener('change', () => updateProducts()));
            document.querySelectorAll('.care-level-filter').forEach(filter => filter.addEventListener('change', () => updateProducts()));
        }

        function updateProducts(page = 1) {
            const queryParams = getActiveFilters();
            queryParams.set('page', page.toString());

            history.pushState({}, '', `${location.pathname}?${queryParams.toString()}`);
            fetch(`/products?${queryParams.toString()}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('products-tiles').innerHTML = data.html;
                    document.getElementById('product-count').textContent = `${data.count}`;
                    document.querySelector('.pagination').innerHTML = data.pagination;
                    document.getElementById('include-planeter-select').value = queryParams.get('sort');
                    bindPaginationLinks();
                })
                .catch(error => console.error('Error loading the products:', error));
        }

        function getActiveFilters() {
            const queryParams = new URLSearchParams();
            const sortValue = document.getElementById('include-planeter-select').value;
            queryParams.set('sort', sortValue);

            const careLevelChecked = document.querySelector('.care-level-filter:checked');
            if (careLevelChecked) {
                queryParams.set('careLevel', careLevelChecked.value);
            }

            document.querySelectorAll('.category-filter:checked').forEach(input => {
                queryParams.append('categories[]', encodeURIComponent(input.value));
            });

            return queryParams;
        }

        function bindPaginationLinks() {
            document.querySelectorAll('#products-tiles .pagination a').forEach(link => {
                link.addEventListener('click', function(event) {
                    event.preventDefault();
                    const page = parseInt(new URL(this.href).searchParams.get('page'));
                    const sort = document.getElementById('include-planeter-select').value;
                    updateProducts(page, sort);
                });
            });
        }

    </script>

@endpush

