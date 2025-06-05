@extends('layouts.app')

@section('content')

<!-- NAVBAR START -->
<style>
    body {
        font-family: 'Roboto', sans-serif;
        margin: 0;
        background-color: #f5f5f5;
        overflow-x: hidden;
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
        margin-left: 8px;
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
        cursor: pointer;
        font-size: 1rem;
        transition: color 0.3s ease;
        font-family: 'Roboto', sans-serif;
    }

    .nav-link-button:hover {
        color: #0099cc;
    }

    .product-container {
        max-width: 800px;
        margin: 120px auto 40px auto; /* Push content below fixed navbar */
        background: #ffffff;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    .product-container img {
        max-width: 100%;
        height: auto;
        border-radius: 12px;
        margin-bottom: 20px;
        border: 2px solid #d5d2f0;
        display: block;
        margin-left: auto;
        margin-right: auto;
    }

    h2 {
        font-size: 28px;
        color: #6c4ce8;
        margin-bottom: 20px;
    }

    p {
        font-size: 16px;
        color: #555;
        margin-bottom: 15px;
    }

    .product-price {
        font-size: 18px;
        color: #6c4ce8;
        font-weight: bold;
    }

    .action-buttons {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-top: 20px;
    }

    .action-buttons a,
    .action-buttons button {
        text-decoration: none;
        padding: 10px 20px;
        font-size: 14px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .edit-button {
        background-color: #6c4ce8;
        color: #ffffff;
    }

    .edit-button:hover {
        background-color: #5233c7;
    }

    .delete-button {
        background-color: #e84c4c;
        color: #ffffff;
    }

    .delete-button:hover {
        background-color: #c73333;
    }

    form {
        display: inline-block;
    }

    .add-to-cart-button {
        background-color: #28a745;
        color: white;
    }

    .add-to-cart-button:hover {
        background-color: #218838;
    }
    
</style>

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
<!-- NAVBAR END -->

<!-- Product Container -->
<div class="product-container">
    <h2>{{ $product->user->name }}</h2>
    <h2>{{ $product->name }}</h2>
    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
    <p>{{ $product->description }}</p>
    <p class="product-price">Price: ${{ $product->price }}</p>

    <div class="action-buttons">
    @auth
        @if(auth()->user()->hasRole('artist') && auth()->user()->id == $product->user_id)
            <a href="{{ route('products.edit', $product->id) }}" class="edit-button">Edit</a>
            <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="delete-button">Delete</button>
            </form>
        @elseif(auth()->user()->hasRole('admin'))
            <!-- Admin can edit and delete any product -->
            <a href="{{ route('products.edit', $product->id) }}" class="edit-button">Edit</a>
            <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="delete-button">Delete</button>
            </form>
        @endif
    @endauth

    @auth
        @if(auth()->user()->hasRole('customer'))
            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                @csrf
                <button type="submit" class="add-to-cart-button">Add to Cart</button>
            </form>
        @endif
    @else
        <p><a href="{{ route('login') }}">Login</a> to add to cart</p>
    @endauth
</div>

</div>

<!-- Interaction Tracking Script -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const userId = {{ auth()->check() ? auth()->id() : 'null' }};
        const productId = {{ $product->id }};

        if (userId && productId) {
            fetch("{{ url('/api/interactions') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    user_id: userId,
                    product_id: productId,
                    action: 'view'
                })
            }).catch(error => console.error('View interaction error:', error));
        }

        const addToCartForm = document.querySelector('.add-to-cart-button')?.closest('form');
        if (addToCartForm && userId) {
            addToCartForm.addEventListener('submit', function () {
                fetch("{{ url('/api/interactions') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        user_id: userId,
                        product_id: productId,
                        action: 'add_to_cart'
                    })
                }).catch(error => console.error('Add to cart interaction error:', error));
            });
        }
    });
</script>

<!-- Review Section -->
<div class="product-container">
    <h3 style="color: #6c4ce8;">Customer Reviews</h3>

    <!-- Display existing reviews -->
    <div style="margin-bottom: 20px; text-align: left;">
        @forelse($product->reviews as $review)
            <div style="border-top: 1px solid #ddd; padding: 10px 0;">
                <strong>{{ $review->user->name }}</strong>
                <p style="margin: 5px 0;">{{ $review->review }}</p>
                <small style="color: #888;">Rated: {{ $review->rating }}/5</small>

                @auth
                    @if(auth()->user()->hasRole('admin'))
                        <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background-color: #e84c4c; color: white; padding: 5px 10px; border: none; border-radius: 4px;">Delete</button>
                        </form>
                    @endif
                @endauth
            </div>
        @empty
            <p>No reviews yet.</p>
        @endforelse
    </div>

    <!-- Review submission form -->
    @auth
        @if(auth()->user()->hasRole('customer'))
            <form action="{{ route('review.product', $product->id) }}" method="POST">
                @csrf

                <label for="rating" style="display:block; margin-top:10px;">Rating</label>
                <select name="rating" required style="padding: 6px 10px; border-radius: 6px;">
                    <option value="">Select Rating</option>
                    @for ($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>

                <label for="review" style="display:block; margin-top:10px;">Review</label>
                <textarea name="review" required style="width: 100%; padding: 10px; border-radius: 6px;"></textarea>

                <button type="submit" style="margin-top: 10px; padding: 8px 20px; background-color: #6c4ce8; color: white; border: none; border-radius: 6px; cursor: pointer;">Submit Review</button>
            </form>

            @if(session('success'))
                <p style="color: green;">{{ session('success') }}</p>
            @endif

            @if($errors->any())
                @foreach($errors->all() as $error)
                    <p style="color: red;">{{ $error }}</p>
                @endforeach
            @endif
        @endif
    @else
        <p><a href="{{ route('login') }}">Login</a> to leave a review</p>
    @endauth
</div>

@endsection