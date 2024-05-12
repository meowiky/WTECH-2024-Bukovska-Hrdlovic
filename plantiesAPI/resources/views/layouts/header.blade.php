<header>
    <div class="pseudo-nav">
        @if (auth()->check())
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <a class="white-text" href="javascript:;" onclick="this.closest('form').submit();">Log out</a>
            </form>
            @if (auth()->user()->isAdmin())
                <a class="white-text" href="{{ route('admin.dashboard') }}">Admin Dashboard</a>
            @endif
        @else
            <a class="white-text" href="{{ route('register') }}">Sign up / Sign In</a>
        @endif
        <a href="{{ route('profile') }}">
            <img src="{{ asset('assets/profile.svg') }}"/>
        </a>
    </div>
    <div class="main-nav">
        <a href="{{ url('/') }}">
            <h1 class="logo inline">PLANTIES</h1>
        </a>
        <input type="checkbox" id="hamburger-checkbox" />
        <label id="hamburger-label" for="hamburger-checkbox">
            <span id="hamburger-line"></span>
        </label>
        <nav>
            <ul>
                <a href="{{ url('/') }}"><li>Home</li></a>
                <a href="{{ route('products') }}"><li>Products</li></a>
            </ul>
            <div id="menu-thing">
                <span class="divider"></span>
                <div class="inline">
                    <div class="relative" id="cart-container">
                        <img src="{{ asset('assets/shop.svg') }}" id="shop-icon" />
                        <span class="notification">{{ count($cartItems) }}</span>
                    </div>
                    <div>
                        <div class="light">Shopping cart:</div>
                        <div class="bold">{{ number_format($totalPrice, 2) }}</div>
                    </div>
                </div>
            </div>
        </nav>
    </div>
    <div class="cart-dropdown">
        <div class="cart-dropdown-content">
            <div class="cart-items">
                @foreach ($cartItems as $item)
                <div class="cart-item">
                    <img src="{{ asset('storage/' . $item['image_path']) }}" alt="{{ $item['name'] }}" class="cart-item-image" />
                    <div class="cart-item-details">
                        <div class="cart-item-name">{{ $item['name'] }}</div>
                        <div class="cart-item-quantity">{{ $item['quantity'] }} x ${{ number_format($item['price'], 2) }}</div>
                        <div class="cart-item-subtotal">${{ number_format($item['subtotal'], 2) }}</div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="cart-total">
                Total: <span class="total-price">${{ number_format($totalPrice, 2) }}</span>
            </div>
            <form action="{{ route('cartpage') }}" method="GET">
                <button type="submit" class="btn-checkout">Checkout</button>
            </form>
        </div>
    </div>

</header>

@push('scripts')
    <script>
        document.getElementById('shop-icon').addEventListener('click', function() {
            const cartDropdown = document.querySelector('.cart-dropdown');
            cartDropdown.style.display = cartDropdown.style.display === 'none' ? 'block' : 'none';
        });

        function closeCart() {
            document.querySelector('.cart-dropdown').style.display = 'none';
        }

        window.onclick = function(event) {
            if (!event.target.matches('#shop-icon')) {
                closeCart();
            }
        };
    </script>
@endpush
