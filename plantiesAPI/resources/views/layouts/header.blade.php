<header>
    <div class="pseudo-nav">
        @if (auth()->check())
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <a class="white-text" href="javascript:;" onclick="this.closest('form').submit();">Log out</a>
            </form>
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
                <a href="{{ url('products') }}"><li>Products</li></a>
            </ul>
            <div id="menu-thing">
                <div class="relative inline">
                    <input placeholder="Search" class="borderless" />
                    <img src="{{ asset('assets/search.svg') }}" class="input-icon" />
                </div>
                <span class="divider"></span>
                <div class="inline">
                    <div class="relative">
                        <img src="{{ asset('assets/shop.svg') }}" id="shop-icon" />
                        <span class="notification">2</span>
                    </div>
                    <div>
                        <div class="light">Shopping cart:</div>
                        <div class="bold">$57.00</div>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</header>
