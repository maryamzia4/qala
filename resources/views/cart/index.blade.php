@extends('layouts.app')

@section('content')
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    body {
        margin: 0;
        font-family: 'Roboto', sans-serif;
        overflow-x: hidden;
        background-color: #f5f5f5;
    }

    .navbar {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        background: white;
        display: flex;
        justify-content: space-around;
        align-items: center;
        padding: 15px 20px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        z-index: 1000;
    }

    .navbar .logo {
        font-size: 1.5rem;
        font-weight: bold;
        color: #0099cc;
        text-decoration: none;
        display: flex;
        align-items: center;
    }

    .navbar .logo-img {
        height: 30px;
        width: auto;
        margin-left: 10px;
    }

    .navbar .nav-links {
        display: flex;
        gap: 30px;
        align-items: center;
    }

    .navbar .nav-links a {
        color: #333;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.3s ease;
    }

    .navbar .nav-links a:hover {
        color: #0099cc;
    }

    .dropdown {
        position: relative;
        display: inline-block;
    }

    .dropbtn {
        background: none;
        color: #333;
        font-weight: 500;
        font-size: 1rem;
        border: none;
        cursor: pointer;
        transition: color 0.3s ease;
        font-family: 'Roboto', sans-serif;
        text-decoration: none;
        padding: 0;
    }

    .dropbtn:hover {
        color: #0099cc;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
        z-index: 1;
    }

    .dropdown:hover .dropdown-content {
        display: block;
    }

    .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    .dropdown-content a:hover {
        background-color: #f1f1f1;
    }

    .nav-link-button {
        color: #333;
        background: none;
        border: none;
        font-weight: 500;
        text-decoration: none;
        cursor: pointer;
        font-size: 1rem;
        transition: color 0.3s ease;
        font-family: 'Roboto', sans-serif;
    }

    .nav-link-button:hover {
        color: #0099cc;
    }

    .cart-btn {
        padding: 6px 12px;
        border-radius: 4px;
        border: none;
        background-color: #007bff;
        color: white;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        margin-top: 5px;
    }

    .cart-btn:hover {
        background-color: #0056b3;
    }

    /* Padding to account for fixed navbar */
    .container {
        padding-top: 100px;
    }

    .cart-title {
        font-size: 2.5em;
        margin-bottom: 30px;
        color: #4CAF50;
        text-align: center;
    }

    .cart-table {
        width: 100%;
        border-collapse: collapse;
    }

    .cart-table th, .cart-table td {
        padding: 12px;
        text-align: left;
        border: 1px solid #ddd;
    }

    .cart-table th {
        background-color: #f4f4f4;
        font-weight: bold;
    }

    .cart-table tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .quantity-input {
        width: 60px;
        padding: 5px;
        margin-right: 10px;
        border-radius: 4px;
        border: 1px solid #ccc;
    }

    .update-btn, .remove-btn {
        padding: 6px 12px;
        border-radius: 4px;
        border: none;
        cursor: pointer;
    }

    .update-btn {
        background-color: #4CAF50;
        color: white;
    }

    .remove-btn {
        background-color: #f44336;
        color: white;
    }

    .update-btn:hover, .remove-btn:hover {
        opacity: 0.8;
    }

    .total-amount {
        font-size: 1.5em;
        margin-top: 20px;
        font-weight: bold;
        color: #333;
    }

    .view-btn {
        padding: 6px 12px;
        border-radius: 4px;
        border: none;
        background-color: #007bff;
        color: white;
        text-align: center;
        display: inline-block;
        text-decoration: none;
        margin-top: 5px;
    }

    .view-btn:hover {
        background-color: #0056b3;
    }

    .btn-checkout {
        padding: 12px 24px;
        font-size: 1.1em;
        font-weight: bold;
        background-color: #007bff;
        color: white;
        border-radius: 5px;
        border: none;
        text-align: center;
        display: inline-block;
        text-decoration: none;
    }

    .btn-checkout:hover {
        background-color: #0056b3;
    }

    .total-checkout-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 20px;
        margin-right: 160px;
    }
</style>

<!-- Navigation Bar -->
<nav class="navbar">
    <a href="javascript:history.back()" class="logo">
    QALA
    <img src="{{ asset('images/logo.png') }}" alt="QALA Logo" class="logo-img">
</a>

    <div class="nav-links">
        <a href="{{ url('/') }}">Home</a>
        <a href="{{ url('/') }}">About Us</a>
        <a href="{{ route('products.index') }}">Products</a>

        @if(!Auth::check() || (Auth::check() && auth()->user()->hasRole('customer')))
            <a href="{{ route('artist-profile.index') }}">Artists</a>
        @endif

        <a href="{{ url('/') }}">Contact</a>

        @if(Auth::check())
            @if(auth()->user()->hasRole('artist'))
                @php $user = auth()->user(); @endphp
                @if($user->artistProfile)
                    <a href="{{ route('artist-profile.show', $user->id) }}">Profile</a>
                @else
                    <a href="{{ route('artist-profile.edit', $user->id) }}">Complete Profile</a>
                @endif
            @endif

            <div class="dropdown">
                <button class="dropbtn">Switch to</button>
                <div class="dropdown-content">
                    @if(auth()->user()->hasRole('artist'))
                        <a href="{{ route('switchRole', ['role' => 'customer']) }}">Switch to Customer</a>
                    @elseif(auth()->user()->hasRole('customer'))
                        <a href="{{ route('switchRole', ['role' => 'artist']) }}">Switch to Artist</a>
                    @endif
                </div>
            </div>

            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="nav-link-button">Logout</button>
            </form>

            @if(auth()->user()->hasRole('customer'))
                <a href="{{ route('cart.index') }}" class="nav-link-button">View Cart</a>
            @endif
        @else
            <a href="{{ route('login') }}">Login</a>
            <a href="{{ route('register') }}">Register</a>
        @endif
    </div>
</nav>
</head>

<div class="container">
    <h1 class="cart-title">Your Cart</h1>
    <a href="{{ route('orders.index') }}" class="btn btn-outline-primary btn-lg mb-3">Order History</a>

    @if($cart && $cart->items->count())
        <table class="table cart-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cart->items as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>${{ $item->price }}</td>
                        <td>
                            <form action="{{ route('cart.update', $item->product->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" required class="quantity-input">
                                <button type="submit" class="btn update-btn">Update</button>
                            </form>
                        </td>
                        <td>${{ $item->price * $item->quantity }}</td>
                        <td>
                            <form action="{{ route('cart.remove', $item->product->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn remove-btn">Remove</button>
                            </form>
                            <a href="{{ route('products.show', $item->product->id) }}" class="btn btn-primary view-btn">View Product</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total-checkout-container">
            <h3 class="total-amount">
                Total: ${{ $cart->items->sum(fn($item) => $item->price * $item->quantity) }}
            </h3>
            <a href="{{ route('checkout.form') }}" class="btn-checkout">Proceed to Checkout</a>
        </div>
    @else
        <p>Your cart is empty.</p>
    @endif
</div>
@endsection
