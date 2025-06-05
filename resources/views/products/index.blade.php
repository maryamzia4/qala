@extends('layouts.app')

@section('content')
@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
@endpush
<!-- Toast -->
<div class="position-fixed top-0 end-0 p-3" style="z-index: 1055">
    <div id="cartToast" class="toast align-items-center text-white bg-success border-0" role="alert">
        <div class="d-flex">
            <div class="toast-body">
                🛒 Product added to cart!
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>

<!-- Cart icon to animate-->
<a href="{{ route('cart.index') }}" id="cartIcon">
    <i class="bi bi-cart-fill fs-3 text-dark"></i>
</a>


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

    .logo-img {
        height: 30px;
        width: auto;
        margin-left: 10px;
    }

    .navbar .nav-links {
        display: flex;
        gap: 30px;
        align-items: center;
    }

    .navbar .nav-links a,
    .dropbtn,
    .nav-link-button {
        color: #333;
        background: none;
        border: none;
        font-weight: 500;
        font-size: 1rem;
        text-decoration: none;
        cursor: pointer;
        font-family: 'Roboto', sans-serif;
        transition: color 0.3s ease;
    }

    .navbar .nav-links a:hover,
    .dropbtn:hover,
    .nav-link-button:hover {
        color: #0099cc;
    }

    .dropdown {
        position: relative;
        display: inline-block;
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

    .section-title {
        text-align: center;
        font-size: 32px;
        font-weight: bold;
        color: #6c4ce8;
        margin-top: 100px;
        margin-bottom: 20px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        max-width: 1000px;
        margin: 0 auto 40px auto;
        padding: 0 20px;
    }

    .product-card {
        background-color: #ffffff;
        border-radius: 12px;
        box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
        padding: 20px;
        text-align: center;
        display: flex;
        flex-direction: column;  /* Ensures the image and content stack vertically */
        justify-content: space-between;  /* Space between image and button */
        height: 100%;
        transition: transform 0.3s;
    }

    .product-card:hover {
        transform: translateY(-5px);
    }

    .product-card img {
        width: 100%;
        height: auto;
        border-radius: 12px;
        margin-bottom: 15px;
        border: 2px solid #d5d2f0;
    }

    .product-card h3 {
        font-size: 20px;
        color: #6c4ce8;
        margin-bottom: 10px;
    }

    .product-card p {
        font-size: 14px;
        color: #555;
        margin-bottom: 8px;
    }

    .product-price {
        font-weight: bold;
        color: #6c4ce8;
        margin-bottom: 10px;
    }

    .add-to-cart-button {
        background-color: #28a745;
        color: white;
        padding: 8px 16px;
        font-size: 14px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        align-self: center;  /* Centers the button horizontally */
    }

    .add-to-cart-button:hover {
        background-color: #218838;
    }

    /* Additional spacing and layout fixes */
    .product-card .product-info {
        flex-grow: 1;  /* Ensures the image and button stay aligned */
    }
     .btn-purple {
  background-color: #6f42c1; 
  border: none;
}

.btn-purple:hover {
  background-color: #5a32a3; 
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

<!-- Product Section -->
<h2 class="section-title">Products</h2>
<!-- Category Filter -->
<div class="mb-4 d-flex align-items-center gap-3 flex-wrap " style="margin-left: 10.5rem;">
    <div class="dropdown">
        <button class="btn btn-purple text-white dropdown-toggle" type="button" id="categoryDropdown" data-bs-toggle="dropdown" >
            {{ request('category') ? ucwords(str_replace('_', ' ', request('category'))) : 'All Categories' }}
        </button>
        <ul class="dropdown-menu" aria-labelledby="categoryDropdown">
            <li><a class="dropdown-item {{ request('category') == '' ? 'active' : '' }}" href="{{ route('products.index') }}">All Categories</a></li>
            <li><a class="dropdown-item {{ request('category') == 'calligraphy' ? 'active' : '' }}" href="{{ route('products.index', ['category' => 'calligraphy']) }}">Calligraphy</a></li>
            <li><a class="dropdown-item {{ request('category') == 'resin_art' ? 'active' : '' }}" href="{{ route('products.index', ['category' => 'resin_art']) }}">Resin Art</a></li>
            <li><a class="dropdown-item {{ request('category') == 'abstract_art' ? 'active' : '' }}" href="{{ route('products.index', ['category' => 'abstract_art']) }}">Abstract Art</a></li>
            <li><a class="dropdown-item {{ request('category') == 'digital_art' ? 'active' : '' }}" href="{{ route('products.index', ['category' => 'digital_art']) }}">Digital Art</a></li>
            <li><a class="dropdown-item {{ request('category') == 'painting' ? 'active' : '' }}" href="{{ route('products.index', ['category' => 'painting']) }}">Painting</a></li>
            <li><a class="dropdown-item {{ request('category') == 'faceless_portraits' ? 'active' : '' }}" href="{{ route('products.index', ['category' => 'faceless_portraits']) }}">Faceless Portraits</a></li>
            <li><a class="dropdown-item {{ request('category') == 'landscape' ? 'active' : '' }}" href="{{ route('products.index', ['category' => 'landscape']) }}">Landscape</a></li>
            <li><a class="dropdown-item {{ request('category') == 'fabric_painting' ? 'active' : '' }}" href="{{ route('products.index', ['category' => 'fabric_painting']) }}">Fabric Painting</a></li>
        </ul>
    </div>
    @if(request('category'))
        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Clear Filter</a>
    @endif
</div>


<div class="products-grid">
    @foreach($products as $product)
        <div class="product-card">
            <a href="{{ route('products.show', $product->id) }}" 
               onclick="logInteraction({{ auth()->check() ? auth()->id() : 'null' }}, {{ $product->id }}, 'click')">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                <h3>{{ $product->name }}</h3>
            </a>
            <p>{{ Str::limit($product->description, 60) }}</p>
            <p class="product-price">${{ $product->price }}</p>

            @auth
                @if(auth()->user()->hasRole('customer'))
                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="add-to-cart-form">
                        @csrf
                        @if(auth()->user()->hasRole('customer'))
    <button class="btn btn-success add-to-cart-btn" data-product-id="{{ $product->id }}">
        Add to Cart
    </button>
@endif

                        <div class="cart-message" id="cart-message-{{ $product->id }}"></div>
                    </form>

                @endif
            @else
                <p><a href="{{ route('login') }}">Login</a> to add to cart</p>
            @endauth
        </div>
    @endforeach
</div>

<!-- Recommended Section -->
 @if(auth()->check() && auth()->user()->hasRole('customer'))
<h2 class="section-title">Recommended For You</h2>
<div class="products-grid">
    @foreach($recommendedProducts as $product)
        <div class="product-card">
            <a href="{{ route('products.show', $product->id) }}" 
               onclick="logInteraction({{ auth()->check() ? auth()->id() : 'null' }}, {{ $product->id }}, 'click')">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                <h3>{{ $product->name }}</h3>
            </a>
            <p>{{ Str::limit($product->description, 60) }}</p>
            <p class="product-price">${{ $product->price }}</p>

            @auth
                @if(auth()->user()->hasRole('customer'))
                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="add-to-cart-form">
                        @csrf
                        @if(auth()->user()->hasRole('customer'))
    <button class="btn btn-success add-to-cart-btn" data-product-id="{{ $product->id }}">
        Add to Cart
    </button>
@endif

                        <div class="cart-message" id="cart-message-{{ $product->id }}"></div>
                    </form>
                @endif
            @else
                <p><a href="{{ route('login') }}">Login</a> to add to cart</p>
            @endauth
        </div>
    @endforeach
</div>
@endif

<!-- Click Tracking -->
<script>
    function logInteraction(userId, productId, action) {
        if (!userId || !productId) return;
        fetch("{{ url('/api/interactions') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                user_id: userId,
                product_id: productId,
                action: action
            })
        }).catch(error => console.error('Interaction logging failed:', error));
    }
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const forms = document.querySelectorAll('.add-to-cart-form');

    forms.forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault(); // prevent normal form submission

            const button = form.querySelector('.add-to-cart-button');
            const productId = button.getAttribute('data-product-id');
            const messageDiv = document.getElementById(`cart-message-${productId}`);

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({})
            })
            .then(response => {
                if (!response.ok) throw new Error("Add to cart failed");
                return response.json(); // if your controller returns JSON
            })
            .then(data => {
                messageDiv.textContent = "✅ Added to cart!";
                messageDiv.style.color = "green";

                // Auto-hide message after 2 seconds
                setTimeout(() => {
                    messageDiv.textContent = "";
                }, 2000);
            })
            .catch(error => {
                messageDiv.textContent = "❌ Failed to add.";
                messageDiv.style.color = "red";
            });
        });
    });
});
</script>

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endpush
@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
@endpush

@push('scripts')
<script>
    $(document).ready(function () {
        $('.add-to-cart-btn').on('click', function (e) {
            e.preventDefault();
            const productId = $(this).data('product-id');

            $.ajax({
                 url: `/cart/add/${productId}`,
    type: 'POST',
    data: {
        _token: '{{ csrf_token() }}'
    },
                success: function (response) {
                    // Toast message
                    const toastEl = document.getElementById('cartToast');
                    const toast = new bootstrap.Toast(toastEl);
                    toast.show();

                    // Animate cart icon
                    $('#cartIcon').addClass('animate__animated animate__bounce');
                    setTimeout(() => {
                        $('#cartIcon').removeClass('animate__animated animate__bounce');
                    }, 1000);
                },
                error: function () {
                    alert('Failed to add product to cart.');
                }
            });
        });
    });
</script>
@endpush

@endsection
