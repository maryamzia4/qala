<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Success</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap + Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    {{-- Custom Styles --}}
    <style>
        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
            overflow-x: hidden;
            background-color: #f5f5f5;
            padding-top: 80px; /* offset for navbar */
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
        .nav-link-button:hover,
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
    </style>
</head>

<body>
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

    <!-- Order Success Card -->
    <div class="container mt-5">
    <div class="card shadow-lg border-success">
        <div class="card-body text-center">
            <h1 class="text-success">
                <i class="bi bi-check-circle-fill"></i>
                Payment Successful!
            </h1>
            <p class="lead mt-3">Thank you for your payment. Your transaction has been completed successfully.</p>

            <!-- Order details for regular orders -->
            @isset($order)
                <div class="mt-4">
                    <h4>Order Summary</h4>
                    <ul class="list-group mb-4">
                        <li class="list-group-item"><strong>Order ID:</strong> {{ $order->id }}</li>
                        <li class="list-group-item"><strong>Total Amount:</strong> ${{ number_format($order->total_price, 2) }}</li>
                        <li class="list-group-item"><strong>Status:</strong> {{ ucfirst($order->status) }}</li>
                    </ul>
                </div>
            @endisset

            <!-- Commission details for custom requests -->
            @isset($commission)
                <div class="mt-4">
                    <h4>Commission Summary</h4>
                    <ul class="list-group mb-4">
                        <li class="list-group-item"><strong>Commission ID:</strong> {{ $commission->id }}</li>
                        <li class="list-group-item"><strong>Title:</strong> {{ $commission->title }}</li>
                        <li class="list-group-item"><strong>Description:</strong> {{ $commission->description }}</li>
                        <li class="list-group-item"><strong>Price:</strong> ${{ number_format($commission->price, 2) }}</li>
                        <li class="list-group-item"><strong>Status:</strong> {{ ucfirst($commission->status) }}</li>
                        <li class="list-group-item"><strong>Payment Status:</strong> {{ ucfirst($commission->payment_status) }}</li>
                    </ul>
                </div>
            @endisset

            <a href="{{ route('commissions.customer') }}" class="btn btn-outline-success mt-3">Custom Orders History</a>
            <a href="{{ route('orders.index') }}" class="btn btn-outline-success mt-3">Product Order History</a>
            <a href="{{ route('home') }}" class="btn btn-secondary mt-3">Back to Home</a>
        </div>
    </div>
</div>

</body>
</html>
