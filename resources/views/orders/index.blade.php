{{-- resources/views/orders/index.blade.php --}}
@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
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
    }
    .navbar .nav-links {
        display: flex;
        gap: 30px;
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
    .logo-img {
        height: 30px;
        width: auto;
        margin-right: 10px;
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
    .content-wrapper {
        margin-top: 100px;
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

<!-- Orders Content -->
<div class="container content-wrapper">
    <h1 class="mb-4">Your Orders</h1>

    @if($orders->count())
        <div class="table-responsive">
            <table class="table table-striped table-bordered shadow-sm bg-white">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Order ID</th>
                        <th scope="col">Total Price</th>
                        <th scope="col">Status</th>
                        <th scope="col">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>${{ number_format($order->total_price, 2) }}</td>
                            <td>{{ ucfirst($order->status) }}</td>
                            <td>{{ $order->created_at->format('Y-m-d') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info">You have no orders yet.</div>
    @endif
</div>
@endsection
