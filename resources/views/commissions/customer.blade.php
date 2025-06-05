<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Commission Requests</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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

    <div class="container mt-5">
    <h2 class="mb-4">Your Commission Requests</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Artist</th>
                <th>Status</th>
                <th>Price</th>
                <th>Payment Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($commissions as $commission)
            <tr>
                <td>{{ $commission->title }}</td>
                <td>{{ $commission->artist->artistProfile->username ?? 'N/A' }}</td>
                <td>
                    <span class="badge 
                        @if($commission->status == 'pending') badge-secondary 
                        @elseif($commission->status == 'approved') badge-success 
                        @elseif($commission->status == 'rejected') badge-danger 
                        @elseif($commission->status == 'ready') badge-warning 
                        @elseif($commission->status == 'delivered') badge-primary 
                        @endif">
                        {{ ucfirst($commission->status) }}
                    </span>
                </td>
                <td>$ {{ number_format($commission->price, 2) }}</td>
                <td>
                    <span class="badge 
                        @if($commission->payment_status == 'unpaid') badge-danger 
                        @elseif($commission->payment_status == 'paid') badge-success 
                        @endif">
                        {{ ucfirst($commission->payment_status) }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('commissions.show', $commission->id) }}" class="btn btn-info btn-sm">View</a>

                    @if($commission->status == 'approved' && $commission->payment_status == 'unpaid')
                        <form action="{{ route('checkout.commissionCheckout', $commission->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-sm">Proceed to Payment</button>
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

</body>
</html>
