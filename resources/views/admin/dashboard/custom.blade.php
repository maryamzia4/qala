<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Custom Commission Requests</title>
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

        .table th, .table td {
            vertical-align: middle;
        }

        .badge {
            font-size: 0.85rem;
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
        <h2 class="mb-4 text-center">All Custom Commission Requests</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($commissions->isEmpty())
            <div class="alert alert-info">No commission requests found.</div>
        @else
            <div class="card shadow-lg rounded">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Customer</th>
                                    <th>Artist</th>
                                    <th>Title</th>
                                    <th>Delivery Type</th>
                                    <th>Status</th>
                                    <th>Payment Status</th>
                                    <th>Requested On</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($commissions as $index => $commission)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $commission->customer->name ?? 'N/A' }}</td>
                                        <td>{{ $commission->artist->name ?? 'N/A' }}</td>
                                        <td>{{ $commission->title }}</td>
                                        <td>{{ ucfirst($commission->delivery_type) }}</td>
                                        <td>
                                            <span class="badge 
                                                @if($commission->status === 'approved') bg-success
                                                @elseif($commission->status === 'rejected') bg-danger
                                                @elseif($commission->status === 'ready') bg-warning text-dark
                                                @elseif($commission->status === 'delivered') bg-primary
                                                @else bg-secondary
                                                @endif">
                                                {{ ucfirst($commission->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge 
                                                {{ $commission->payment_status === 'paid' ? 'bg-success' : 'bg-danger' }}">
                                                {{ ucfirst($commission->payment_status) }}
                                            </span>
                                        </td>
                                        <td>{{ $commission->created_at->format('d M Y') }}</td>
                                        <td>
                                            <a href="{{ route('commissions.show', $commission->id) }}" class="btn btn-outline-primary btn-sm">
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
</body>
</html>
