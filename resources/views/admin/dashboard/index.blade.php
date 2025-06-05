<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Dashboard</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

  <!-- Feather Icons -->
  <script src="https://unpkg.com/feather-icons"></script>

  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <!-- Custom Styles -->
  <style>
    body {
      font-family: 'Inter', sans-serif;
      background-color: #f4f6f9;
    }

    .sidebar {
      min-height: 100vh;
      background-color: #ffffff;
      border-right: 1px solid #dee2e6;
    }

    .sidebar .nav-link {
      color: #333;
    }

    .sidebar .nav-link.active {
      background-color: #0d6efd;
      color: white;
    }

    .card {
      height: 100%;
    }

    .card-body {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
    }

    footer {
      padding: 2rem 0;
    }
  </style>
</head>

<body>
  <div class="container-fluid">
    <div class="row">

      <!-- Sidebar -->
      <nav class="col-md-3 col-lg-2 d-md-block sidebar p-3">
        <h4 class="mb-3">Qala</h4>
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link active" href="#">
              <i data-feather="sliders"></i> Dashboard
            </a>
            <a class="nav-link" href="#monthly-sales" onclick="document.querySelector('#monthly-sales').scrollIntoView({ behavior: 'smooth' }); return false;">
              <i data-feather="sliders"></i> Monthly Sales
            </a>
          </li>

          <li class="mt-3 fw-bold">All Artists</li>
          <li class="nav-item"><a class="nav-link" href="{{ route('artist-profile.index') }}"><i data-feather="plus"></i> Profiles</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('admin.artists') }}"><i data-feather="list"></i> Manage</a></li>

          <li class="mt-3 fw-bold">All Products</li>
          <li class="nav-item"><a class="nav-link" href="{{ route('products.index') }}"><i data-feather="plus"></i> Products</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('admin.products') }}"><i data-feather="list"></i> Manage</a></li>

          <li class="mt-3 fw-bold">Custom Requests</li>
          <li class="nav-item"><a class="nav-link" href="{{ route('admin.custom.requests') }}"><i data-feather="file-text"></i> View Custom Requests</a></li>
      

          <li class="mt-3 fw-bold">Logout</li>
          <li class="nav-item">
            <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              <i data-feather="log-out"></i> Logout
            </a>
          </li>
        </ul>

        <!-- Hidden logout form outside <ul> -->
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
        </form>
      </nav>

      <!-- Main Content -->
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">

        <!-- Dashboard Cards -->
<div class="container-fluid">
  <div class="row row-cols-1 row-cols-md-4 g-4">
    <!-- Total Artists -->
    <div class="col">
      <div class="card h-100 text-bg-light shadow-sm">
        <div class="card-body text-center">
          <h5 class="card-title">🎨 Total Artist Profiles</h5>
          <p class="card-text display-6 fw-bold">{{ $totalArtists ?? 0 }}</p>
        </div>
      </div>
    </div>

    <!-- Total Products -->
    <div class="col">
      <div class="card h-100 text-bg-light shadow-sm">
        <div class="card-body text-center">
          <h5 class="card-title">🛍 Total Products</h5>
          <p class="card-text display-6 fw-bold">{{ $totalProducts ?? 0 }}</p>
        </div>
      </div>
    </div>

    <!-- New Users -->
    <div class="col">
      <div class="card h-100 text-bg-light shadow-sm">
        <div class="card-body text-center">
          <h5 class="card-title">🆕 New Users (24h)</h5>
          <p class="card-text display-6 fw-bold">{{ $newUsersLast24Hours }}</p>
        </div>
      </div>
    </div>

    <!-- Total Orders -->
    <div class="col">
      <div class="card h-100 text-bg-light shadow-sm">
        <div class="card-body text-center">
          <h5 class="card-title">📦 Total Orders</h5>
          <p class="card-text display-6 fw-bold">{{ $totalOrders }}</p>
        </div>
      </div>
    </div>

    <!-- Total Earnings -->
    <div class="col">
      <div class="card h-100 text-bg-light shadow-sm">
        <div class="card-body text-center">
          <h5 class="card-title">💸 Total Earnings</h5>
          <p class="card-text display-6 fw-bold">${{ number_format($totalEarnings, 2) }}</p>
        </div>
      </div>
    </div>

    <!-- Avg per Order -->
    <div class="col">
      <div class="card h-100 text-bg-light shadow-sm">
        <div class="card-body text-center">
          <h5 class="card-title">💳 Avg/Order</h5>
          <p class="card-text display-6 fw-bold">${{ number_format($averageAmountPerOrder, 2) }}</p>
        </div>
      </div>
    </div>

    <!-- Product Sales -->
    <div class="col">
      <div class="card h-100 text-bg-light shadow-sm">
        <div class="card-body text-center">
          <h5 class="card-title">🛒 Product Sales</h5>
          <p class="card-text display-6 fw-bold">${{ $totalProductSales }}</p>
        </div>
      </div>
    </div>

    <!-- Commission Sales -->
    <div class="col">
      <div class="card h-100 text-bg-light shadow-sm">
        <div class="card-body text-center">
          <h5 class="card-title">🎯 Commission Sales</h5>
          <p class="card-text display-6 fw-bold">${{ $totalCommissionSales }}</p>
        </div>
      </div>
    </div>

    <!-- Approved Requests -->
    <div class="col">
      <div class="card h-100 text-bg-light shadow-sm">
        <div class="card-body text-center">
          <h5 class="card-title">✅ Approved Requests</h5>
          <p class="card-text display-6 fw-bold">{{ $totalApproved }}</p>
        </div>
      </div>
    </div>

    <!-- Rejected Requests -->
    <div class="col">
      <div class="card h-100 text-bg-light shadow-sm">
        <div class="card-body text-center">
          <h5 class="card-title">❌ Rejected Requests</h5>
          <p class="card-text display-6 fw-bold">{{ $totalRejected }}</p>
        </div>
      </div>
    </div>

    <!-- Total Requests -->
    <div class="col">
      <div class="card h-100 text-bg-light shadow-sm">
        <div class="card-body text-center">
          <h5 class="card-title">📋 Total Requests</h5>
          <p class="card-text display-6 fw-bold">{{ $totalRequests }}</p>
        </div>
      </div>
    </div>
  </div>
</div>

          

          <!-- Chart Section -->
          <div class="row mt-5" id="monthly-sales">
            <div class="col-md-12">
              <div class="card shadow-sm">
                <div class="card-body">
                  <h5 class="card-title mb-4">📊 Monthly Sales</h5>
                  <canvas id="salesChart" height="100"></canvas>
                </div>
              </div>
            </div>
          </div>

          <!-- Footer -->
          <footer class="mt-5 text-center text-muted small">
            <p class="mb-0">© {{ date('Y') }} Qala Admin Panel. All rights reserved.</p>
            <ul class="list-inline mt-2">
              <li class="list-inline-item"><a href="#" class="text-muted">Support</a></li>
              <li class="list-inline-item"><a href="#" class="text-muted">Privacy</a></li>
              <li class="list-inline-item"><a href="#" class="text-muted">Terms</a></li>
            </ul>
          </footer>
        </div>
      </main>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    feather.replace();
  </script>

  <!-- Chart.js Script -->
  <script>
    const ctx = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: {!! json_encode(array_keys($monthlySales)) !!},
        datasets: [{
          label: 'Sales ($)',
          data: {!! json_encode(array_values($monthlySales)) !!},
          backgroundColor: '#0d6efd'
        }]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              callback: function (value) {
                return '$' + value;
              }
            }
          }
        }
      }
    });
  </script>

</body>

</html>