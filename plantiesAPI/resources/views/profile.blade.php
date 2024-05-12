@extends('layouts.app')

@section('title', 'Profile')

@section('content')
    <section class="green">
        <h1>Profile</h1>
    </section>
    <section>
        <form id="billing-form" method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PATCH')
            <h3>Billing Address</h3>
            <div class="row">
                <div class="form-group">
                    <label>First Name:</label>
                    <input type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}">
                    @error('first_name')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Last Name:</label>
                    <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}">
                    @error('last_name')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label>Street Address:</label>
                <input type="text" name="street" value="{{ old('street', $user->street) }}">
                @error('street')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label>Street Number:</label>
                <input type="text" name="street_number" value="{{ old('street_number', $user->street_number) }}">
                @error('street_number')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label>City:</label>
                <input type="text" name="city" value="{{ old('city', $user->city) }}">
                @error('city')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label>State:</label>
                <input type="text" name="state" value="{{ old('state', $user->state) }}">
                @error('state')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="row">
                <div class="form-group">
                    <label>Country:</label>
                    <select name="country">
                        <option value="" disabled selected>Select Country</option>
                        <option value="SK" @if($user->country == 'SK') selected @endif>Slovakia</option>
                        <option value="CZ" @if($user->country == 'CZ') selected @endif>Czech republic</option>
                    </select>
                    @error('country')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="zip">ZIP Code:</label>
                    <input type="text" name="postal_code" value="{{ old('postal_code', $user->postal_code) }}">
                    @error('postal_code')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <button type="submit" class="btn-checkout">Save Changes</button>
        </form>
    </section>
    <section>
        <form id="billing-form" method="POST" action="{{ route('password.update') }}" class="form-container">
            @csrf
            <input type="hidden" name="_method" value="PUT">

            <h3>Change Password</h3>

            <div class="form-group">
                <label for="current_password">Current Password:</label>
                <input type="password" id="current_password" name="current_password" required placeholder="Enter current password">
                @error('current_password')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="form-group">
                    <label for="new_password">New Password:</label>
                    <input type="password" id="new_password" name="new_password" required placeholder="Enter new password">
                    @error('new_password')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="new_password_confirmation">Confirm New Password:</label>
                    <input type="password" id="new_password_confirmation" name="new_password_confirmation" required placeholder="Confirm new password">
                    @error('new_password_confirmation')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <button type="submit" class="btn-checkout">Change Password</button>
        </form>
    </section>


@endsection
