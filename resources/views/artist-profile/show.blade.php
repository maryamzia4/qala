@extends('layouts.app')

@section('content')
<style>
/* --- Navbar Styles --- */
body {
    margin: 0;
    font-family: 'Roboto', sans-serif;
    overflow-x: hidden;
    background-color: #f5f5f5;
}


.artist-profile {
    max-width: 1000px;
    margin: 50px auto;
    background: #ffffff; 
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
}

.artist-info {
    text-align: center;
    margin-bottom: 30px;
    display: flex;
    flex-direction: column;  
    align-items: center;     
    justify-content: center; 
}

.profile-photo {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #6c4ce8; 
    margin-bottom: 15px;
}

.artist-info h2 {
    font-size: 28px;
    color: #6c4ce8; 
    margin-bottom: 5px;
}

.artist-info p {
    font-size: 16px;
    color: #555; 
    margin: 5px 0;
}

.product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
}

.product-card {
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.2);
}

.product-card img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.product-card h4 {
    font-size: 18px;
    color: #6c4ce8; 
    margin: 10px 0;
}

.product-card p {
    font-size: 16px;
    color: #555;
    margin-bottom: 10px;
}

.product-card a {
    display: inline-block;
    text-decoration: none;
    color: #fff;
    background: #6c4ce8;
    padding: 8px 15px;
    font-size: 14px;
    border-radius: 8px;
    transition: background-color 0.3s ease;
}

.product-card a:hover {
    background: #5233c7; 
}

.artist-profile h3 {
    font-size: 24px;
    color: #6c4ce8; 
    margin-bottom: 20px;
    text-align: center;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.add-product-btn {
    background-color: #6c4ce8;
    color: white;
    padding: 10px 15px;
    font-size: 14px;
    border-radius: 8px;
    text-decoration: none;
    transition: background-color 0.3s ease;
}

.add-product-btn:hover {
    background-color: #5233c7;
    
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

.logo-img {
    height: 30px;
    width: auto;
    margin-left: 8px;
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
    margin-top: 5px;
}
.cart-btn:hover {
    background-color: #0056b3;
}

/* --- Artist Profile Styles --- */
.artist-profile {
    max-width: 1000px;
    margin: 120px auto 50px auto; /* Add top margin to prevent overlap with navbar */
    background: #ffffff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
}

.delete-btn {
    background: #6c4ce8;
    color: white;
    padding: 8px 15px;
    font-size: 14px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.delete-btn:hover {
    background: #c0392b; /* or keep #5233c7 for consistency */
}


</style>

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

<!-- Artist Profile Section -->
<div class="artist-profile">
    <!-- Artist Info Section -->
    <div class="artist-info">
        <img src="{{ asset('storage/' . $artistProfile->profile_picture) }}" alt="{{ $artistProfile->user->name }}" class="profile-photo">
        <h2>{{ $artistProfile->user->name }}</h2>
        <h2>@ {{ $artistProfile->username }}</h2>
        <p>Hometown: {{ $artistProfile->hometown }}</p>

        @if(Auth::id() == $artistProfile->user->id && Auth::user()->role == 'artist')
    <div style="text-align: center; margin: 20px;">
        <a href="{{ route('commissions.index') }}" class="add-product-btn">View Requests</a>
    </div>
@endif

        @if(Auth::user()->role === 'customer' && Auth::id() !== $artistProfile->user->id)
    <a href="{{ route('commissions.create', ['artist_id' => $artistProfile->user->id]) }}" class="add-product-btn">
        Request Custom Order
    </a>
@endif


        @if(Auth::user()->role == 'artist')
            <a href="{{ route('artist-profile.edit') }}" class="add-product-btn">Edit Profile</a>
        @endif
    </div>
    <!--@if(Auth::id() == $artistProfile->user->id && Auth::user()->role == 'artist')
    <a href="{{ route('commissions.index') }}" class="add-product-btn" style="margin-top: 10px;">View Requests</a>
@endif


    
     Products Section -->
    <h3>
        Products by {{ $artistProfile->user->name }}
        @if(Auth::user()->role == 'artist')
            <a href="{{ route('products.create') }}" class="add-product-btn">Add Product</a>
        @endif
    </h3>
    <div class="product-grid">
        @foreach($products as $product)
            <div class="product-card">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                <h4>{{ $product->name }}</h4>
                <p>${{ $product->price }}</p>
                <a href="{{ route('products.show', $product->id) }}">View Details</a>
                @if(Auth::user()->role == 'artist')
                    <a href="{{ route('products.edit', $product->id) }}" class="edit-btn">Edit</a>
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-btn">Delete</button>
                    </form>
                @endif
            </div>
        @endforeach
    </div>
</div>
@endsection
