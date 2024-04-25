@extends('layouts.app')

@section('title', 'Sign In')

@section('content')
    <section class="green">
        <h1>Sign In</h1>
    </section>

    <section class="tight centered-content" id="login">
        <form action="{{ route('login') }}" method="POST" class="box-shadow">
            @csrf
            <h3>Sign In</h3>

            <input placeholder="Email" type="email" name="email" value="{{ old('email') }}" required autofocus />
            @error('email')
            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
            @enderror

            <input placeholder="Password" type="password" name="password" required autocomplete="current-password" />
            @error('password')
            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
            @enderror

            <div id="login-actions">
                <label>
                    <input type="checkbox" name="remember">
                    Remember me
                </label>
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>

            <button type="submit">Login</button>
            <p>
                Don't have an account? <a href="{{ route('register') }}"><b>Register</b></a>
            </p>
        </form>
    </section>
@endsection

