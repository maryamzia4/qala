<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Products</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap + Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
            background-color: #f5f5f5;
            padding-top: 80px;
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

        .navbar form {
            margin-left: 500px;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            color: #0099cc;
            text-decoration: none;
            display: flex;
            align-items: center;
        }

        .logo-img {
            height: 30px;
            margin-left: 10px;
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

        .product-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar">
        <a href="javascript:history.back()" class="logo">
            QALA
            <img src="{{ asset('images/logo.png') }}" alt="QALA Logo" class="logo-img">
        </a>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="nav-link-button">Logout</button>
        </form>
    </nav>

    <div class="container mt-5">
        <h2 class="mb-4 text-center">All Products</h2>
        <div class="card shadow-lg rounded">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">Image</th>
                                <th scope="col">Artist</th>
                                <th scope="col">Product Name</th>
                                <th scope="col">Price</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
    @forelse($products as $product)
        <tr>
            <td>
                <img src="{{ asset('storage/' . $product['image']) }}" alt="Product Image" width="60" height="60" style="object-fit: cover;">
            </td>
            <td>{{ $product['artist_name'] }}</td>
            <td>{{ $product['name'] }}</td>
            <td>$ {{ number_format($product['price'], 2) }}</td>
            <td>
                <a href="{{ route('products.show', $product['id']) }}" class="btn btn-outline-primary btn-sm">
                    View
                </a>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="5" class="text-center text-muted">No products found.</td>
        </tr>
    @endforelse
</tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
