<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Commission Requests</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<style>
    .commission-form {
        max-width: 700px;
        margin: 40px auto;
        background: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.1);
    }

    .commission-form h2 {
        color: #6c4ce8;
        margin-bottom: 25px;
        text-align: center;
    }

    .commission-form label {
        font-weight: bold;
        color: #333;
    }

    .commission-form .form-control {
        margin-bottom: 20px;
    }

    .commission-form .btn-primary {
        background-color: #6c4ce8;
        border: none;
    }

    .commission-form .btn-primary:hover {
        background-color: #5233c7;
    }

    .commission-form .btn-secondary {
        background-color: #aaa;
        border: none;
    }

    .commission-form .btn-secondary:hover {
        background-color: #888;
    }
    
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

<div class="commission-form">
    <h2>Request a Custom Commission from {{ $artist->name }}</h2>

    @if(session('popup'))
        <div class="alert alert-success text-center" id="popup-msg">
            {{ session('popup') }}
        </div>

        <script>
            setTimeout(() => {
                window.location.href = '{{ url('/') }}'; // Redirect after 3 seconds
            }, 3000);
        </script>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('commissions.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="artist_id" value="{{ $artist->id }}">

        <div class="form-group">
            <label for="name">Your Full Name:</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
            <label for="email">Your Email:</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>

        <div class="form-group">
    <label for="phone">Your Phone Number:</label>
    <input type="tel" name="phone" class="form-control" value="{{ old('phone') }}" required placeholder="e.g., +92-300-1234567">
</div>

<div class="form-group">
    <label for="address">Your Address:</label>
    <textarea name="address" class="form-control" rows="2" required placeholder="Street, City, ZIP/Postal Code">{{ old('address') }}</textarea>
</div>


        <div class="form-group">
            <label for="title">Commission Title:</label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea name="description" class="form-control" rows="4" required>{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label for="reference_images">Reference Images (Optional):</label>
            <input type="file" name="reference_images[]" class="form-control" multiple accept="image/*">

        </div>

        <div class="form-group">
            <label for="canvas_size">Preferred Canvas Size:</label>
            <input type="text" name="canvas_size" class="form-control" value="{{ old('canvas_size') }}" placeholder="e.g., A4, A3 or custom" required>
        </div>

        <div class="form-group">
            <label for="deadline">Preferred Deadline:</label>
            <input type="date" name="deadline" class="form-control" min="{{ \Carbon\Carbon::now()->toDateString() }}" value="{{ old('deadline') }}" required>

        </div>

        <div class="form-group">
            <label for="budget">Budget (Price Range):</label>
            <input type="text" name="budget" class="form-control" value="{{ old('budget') }}" placeholder="e.g., $50-$100" required>
        </div>

        <div class="form-group">
    <label for="delivery_type">Delivery Type:</label>
    <select name="delivery_type" class="form-control" required>
        <option value="digital" {{ old('delivery_type') == 'digital' ? 'selected' : '' }}>Digital</option>
        <option value="physical" {{ old('delivery_type') == 'physical' ? 'selected' : '' }}>Physical</option>
        <option value="both" {{ old('delivery_type') == 'both' ? 'selected' : '' }}>Both</option>
    </select>
    @error('delivery_type')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>


        <button type="submit" class="btn btn-primary">Send Request</button>
        <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
