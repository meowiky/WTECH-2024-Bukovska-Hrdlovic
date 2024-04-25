@extends('layouts.app')

@section('title', 'Register')

@section('content')
    <section class="green">
        <h1>Create Account</h1>
    </section>

    <section class="tight centered-content" id="login">
        <form action="{{ route('register') }}" method="POST" class="box-shadow">
            @csrf
            <h3>Create Account</h3>

            <input placeholder="Email" type="email" name="email" value="{{ old('email') }}" required autofocus />
            @error('email')
            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
            @enderror

            <input placeholder="Password" type="password" name="password" required autocomplete="new-password" />
            @error('password')
            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
            @enderror

            <input placeholder="Confirm Password" type="password" name="password_confirmation" required autocomplete="new-password" />
            @error('password_confirmation')
            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
            @enderror

            <button type="submit">Create Account</button>
            <p>
                Already have an account? <a href="{{ route('login') }}"><b>Login</b></a>
            </p>
        </form>
    </section>
@endsection
