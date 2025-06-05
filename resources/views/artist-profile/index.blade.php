<!-- resources/views/artist-profile/index.blade.php -->
@extends('layouts.app')

@section('content')
<!-- Navbar -->
<nav class="navbar">
    <a href="javascript:history.back()" class="logo">
    QALA
    <img src="{{ asset('images/logo.png') }}" alt="QALA Logo" class="logo-img">
</a>

    <div class="nav-links">
        <a href="{{ url('/') }}">Home</a>
        <a href="{{ url('/') }}">About Us</a>
        <a href="{{ route('products.index') }}">Products</a>

        <!-- Show 'Artists' link based on auth and role logic -->
        @if(!Auth::check() || (Auth::check() && auth()->user()->hasRole('customer')))
            <a href="{{ route('artist-profile.index') }}">Artists</a>
        @endif

        <a href="{{ url('/') }}">Contact</a>

        @if(Auth::check())
            @if(auth()->user()->hasRole('artist'))
                @php
                    $user = auth()->user();
                @endphp

                @if($user->artistProfile)
                    <a href="{{ route('artist-profile.show', $user->id) }}">Profile</a>
                @else
                    <a href="{{ route('artist-profile.edit', $user->id) }}">Complete Profile</a>
                @endif
            @endif

            <!-- Dropdown for role switching -->
            <div class="dropdown">
                <button class="dropbtn">Switch to</button>
                <div class="dropdown-content">
                    @if(auth()->user()->hasRole('artist'))
                        <!-- Switch to Customer route -->
                        <a href="{{ route('switchRole', ['role' => 'customer']) }}">Switch to Customer</a>
                    @elseif(auth()->user()->hasRole('customer'))
                        <!-- Switch to Artist route -->
                        <a href="{{ route('switchRole', ['role' => 'artist']) }}">Switch to Artist</a>
                    @endif
                </div>
            </div>

            <!-- Logout Form -->
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="nav-link-button">Logout</button>
            </form>

            <!-- Cart Button for Customers -->
            @if(auth()->user()->hasRole('customer'))
                <a href="{{ route('cart.index') }}" class="nav-link-button">View Cart</a>
            @endif
        @else
            <a href="{{ route('login') }}">Login</a>
            <a href="{{ route('register') }}">Register</a>
        @endif
    </div>
</nav>

<!-- Main Content -->
<div class="container">
    <h1 class="page-title">Artist Profiles</h1>
    <div class="artists-row">
        @foreach ($artists as $artist)
    @if(!$artist->user->hasRole('admin'))
        <div class="artist-card">
            <img src="{{ asset('storage/'.$artist->profile_picture) }}" alt="{{ $artist->username }}">
            <div class="artist-info">
                <h3 class="artist-name">{{ $artist->username }}</h3>
                <p class="artist-bio">{{ Str::limit($artist->bio, 100) }}</p>
            </div>
            <a href="{{ route('artist-profile.show', $artist->user_id) }}" class="view-profile-btn">View Profile</a>
        </div>
    @endif
@endforeach

    </div>
</div>
@endsection

<style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f7f7f7;
        margin: 0;
        padding: 0;
    }
    p{
        padding: 10px;
    }

    /* Navbar styles */
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

    /* Artists Row */
    .artists-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr); /* Limit to 3 profiles per row */
        gap: 25px;
        justify-items: center;
        margin-top: 80px; /* Adjust for fixed navbar */
    }

    .artist-card {
        position: relative;
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        width: 100%;
        max-width: 400px;
        text-align: center;
        padding: 50px;
        transition: transform 0.3s ease-in-out;
        cursor: pointer;
    }

    .artist-card:hover {
        transform: scale(1.05);
    }

    .artist-card img {
        width: 100%;
        height: 240px;
        object-fit: cover;
    }

    .artist-info {
        padding: 20px;
    }

    .artist-name {
        font-size: 20px;
        font-weight: bold;
        color: #333;
    }

    .artist-bio {
        font-size: 16px;
        color: #7d7d7d;
        margin-bottom: 15px;
    }

    /* View Profile Button */
    .view-profile-btn {
        background-color: #725fff;
        color: #fff;
        padding: 12px 20px;
        font-size: 14px;
        font-weight: bold;
        border-radius: 30px;
        text-decoration: none;
        position: absolute;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        transition: background-color 0.3s;
    }

    .view-profile-btn:hover {
        background-color: #5a47d1;
    }

    /* Navbar styles continued */
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
</style>
