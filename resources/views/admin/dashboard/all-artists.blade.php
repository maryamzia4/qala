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
.navbar form {
        margin-left: 500px; /* Adjust this value for desired spacing */
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
        text-decoration: none;
        cursor: pointer;
        font-size: 1rem;
        transition: color 0.3s ease;
        font-family: 'Roboto', sans-serif;
    }

    .nav-link-button:hover {
        color: #0099cc;
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

        
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="nav-link-button">Logout</button>
                </form>

                
        </div>
    </nav>
<div class="container mt-5">
    <h2 class="mb-4 text-center">All Artists</h2>
    <div class="card shadow-lg rounded">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">Username</th>
                            <th scope="col">Email</th>
                            <th scope="col">Total Products</th>
                            <th scope="col">Total Orders</th>
                            <th scope="col">Total Sales </th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($artists as $artist)
                            <tr>
                                <td><strong>{{ $artist['username'] }}</strong></td>
                                <td>{{ $artist['email'] }}</td>
                                <td>{{ $artist['total_products'] }}</td>
                                <td>{{ $artist['total_orders'] }}</td>
                                <td><span class="text-success">$ {{ number_format($artist['total_sales'], 2) }}</span></td>
                                <td>
                                    <a href="{{ route('artist-profile.show', $artist['id']) }}" class="btn btn-outline-primary btn-sm">
                                        View Profile
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No artists found.</td>
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
