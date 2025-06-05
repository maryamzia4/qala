@extends('layouts.app')

@section('content')
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

    /* Adjust page content to avoid overlapping nav bar */
    .content-wrapper {
        padding-top: 100px;
    }

    /* Product Form Styles */
    .header {
        text-align: center;
        margin: 30px 0;
    }

    .header h1 {
        font-size: 32px;
        color: #6c4ce8;
    }

    .container {
        max-width: 600px;
        margin: 0 auto;
        background: #ffffff;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
    }

    .form-label {
        font-size: 16px;
        color: #6c4ce8;
        margin-bottom: 8px;
        display: block;
    }

    .form-control {
        width: 100%;
        padding: 10px;
        font-size: 14px;
        color: #555;
        background-color: #f7f5fe;
        border: 1px solid #d5d2f0;
        border-radius: 8px;
        margin-bottom: 20px;
        transition: border-color 0.3s ease;
    }

    .form-control:focus {
        border-color: #6c4ce8;
        outline: none;
    }

    .btn-primary {
        display: block;
        width: 100%;
        padding: 10px;
        background: #6c4ce8;
        color: #ffffff;
        font-size: 16px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
        background: #5233c7;
    }
</style>

<!-- Navigation Bar -->
<nav class="navbar">
    <a href="#" class="logo">
        QALA
        <img src="{{ asset('images/logo.png') }}" alt="QALA Logo" class="logo-img">
    </a>

    <div class="nav-links">
        <a href="#home">Home</a>
        <a href="#about">About Us</a>
        <a href="{{ route('products.index') }}">Products</a>

        @if(!Auth::check() || (Auth::check() && auth()->user()->hasRole('customer')))
            <a href="{{ route('artist-profile.index') }}">Artists</a>
        @endif

        <a href="#contact-us">Contact</a>

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

<div class="content-wrapper">
    <div class="header">
        <h1>Add Product</h1>
    </div>

    <div class="container">
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Product Name</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select id="category" name="category" class="form-control" required>
                    <option value="">Select Category</option>
                    <option value="calligraphy">Calligraphy</option>
                    <option value="resin_art">Resin Art</option>
                    <option value="abstract_art">Abstract Art</option>
                    <option value="digital_art">Digital Art</option>
                    <option value="painting">Painting</option>
                    <option value="faceless_portraits">Faceless Portraits</option>
                    <option value="landscape">Landscape</option>
                    <option value="fabric_painting">Fabric Painting</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea id="description" name="description" class="form-control" rows="4" required></textarea>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" id="price" name="price" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Upload Image</label>
                <input type="file" id="image" name="image" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Add Product</button>
        </form>
    </div>
</div>
@endsection
