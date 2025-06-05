<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QALA - Art Meets Passion</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
            overflow-x: hidden;
            background-color: #f5f5f5;
        }

        .logo-img {
    height: 30px;  /* Adjust height */
    width: auto;   /* Maintain aspect ratio */
    margin-right: 10px;  /* Optional: space between logo and text */
}

.contact-heading {
    color: black;          /* Set the color */
    text-align: center;      /* Center the text */
    margin-top: 50px;        /* Optional: Adds space from the top */
}



        /* Navigation Bar */
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

        /* Header Section */
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 100vh;
            padding: 0 50px;
            background: #0099cc; /* Sky blue color */
            color: white;
            position: relative;
        }
        .header .text-content {
            max-width: 50%;
        }
        .header h1 {
            font-size: 4rem;
            margin-bottom: 20px;
            color: white;
        }
        .header p {
            font-size: 1.2rem;
            line-height: 1.8;
            margin-bottom: 30px;
        }
        .header .btn {
            background: #ff5555;
            color: white;
            padding: 15px 30px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 500;
            transition: background 0.3s ease;
        }
        .header .btn:hover {
            background: #e64545;
        }
        .header .image-content {
            max-width: 50%;
            text-align: right;
        }
        .header .image-content img {
            max-width: 100%;
            height: auto;
        }

        /* Content Below Header */
        .content {
            padding: 80px 50px;
            background: #f5f5f5;
            text-align: center;
        }
        .content h2 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: #333;
        }
        .content p {
            font-size: 1.2rem;
            line-height: 1.8;
            color: #666;
        }

        /* Manage Section */
        .manage {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 50px 20px;
            background: #ffffff;
        }
        .manage img {
            max-width: 50%;
            height: auto;
            margin-right: 30px;
        }
        .manage .text {
            max-width: 500px;
        }
        .manage .text h2 {
            font-size: 2rem;
            margin-bottom: 20px;
            color: #222;
        }
        .manage .text p {
            font-size: 1rem;
            color: #555;
            line-height: 1.8;
        }

        /* Features Section */
        .features {
            background: #0099cc;
            color: white;
            padding: 50px 20px;
            text-align: center;
        }
        .features .feature-grid {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
        }
        .features .feature {
            background: white;
            color: #0099cc;
            padding: 20px;
            border-radius: 10px;
            flex: 1;
            max-width: 300px;
            text-align: center;
        }
        .features .feature img {
            width: 50px;
            margin-bottom: 10px;
        }
        .features .feature h3 {
            margin: 10px 0;
            font-size: 1.2rem;
        }
        .features .feature p {
            font-size: 0.9rem;
            line-height: 1.6;
        }

        /* Contact Section */
        .section {
            background-color: #f5f5f5;
            padding: 50px 20px;
            text-align: center;
        }
        .contact-form {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .contact-field {
            width: 98%;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }
        .main-button {
            background-color: #ff5555;
            color: white;
            padding: 15px 30px;
            border-radius: 5px;
            font-weight: 500;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }
        .main-button:hover {
            background-color: #e64545;
        }
        .container-fluid {
            max-width: 1200px;
            margin: 0 auto;
        }
        footer {
            text-align: center;
            padding: 20px;
            background: #222;
            color: white;
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
    padding: 0; /* Optional: remove default button padding */
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
    .cart-btn {
    padding: 6px 12px;
    border-radius: 4px;
    border: none;
    background-color: #007bff;
    color: white;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    margin-top: 5px;
}

.cart-btn:hover {
    background-color: #0056b3;
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
    <a href="#" class="logo">
        QALA
        <img src="{{ asset('images/logo.png') }}" alt="QALA Logo" class="logo-img">
    </a>

    <div class="nav-links">
        <a href="#home">Home</a>
        <a href="#about">About Us</a>
        <a href="{{ route('products.index') }}">Products</a>
        
        <!-- Show 'Artists' link based on auth and role logic -->
@if(!Auth::check() || (Auth::check() && auth()->user()->hasRole('customer')))
    <a href="{{ route('artist-profile.index') }}">Artists</a>
@endif
        

<!-- Conditional 'Contact' link -->
@if(Auth::check() && auth()->user()->hasRole('customer'))
    <a href="{{ route('commissions.customer') }}">Custom Requests</a>
@else
    <a href="#contact-us">Contact</a>
@endif

        @if(Auth::check())
    @if(auth()->user()->hasRole('artist'))
        @php
            $user = auth()->user();
        @endphp

        @if($user->artistProfile)
            <a href="{{ route('artist-profile.show', $user->id) }}">Profile</a>
        @else
            <a href="{{ route('artist-profile.edit', $user->id) }}">Complete Profile</a>
        @endif
    @endif

            
            <!-- Dropdown for role switching -->
            <div class="dropdown">
                <button class="dropbtn">Switch to</button>
                <div class="dropdown-content">
                    @if(auth()->user()->hasRole('artist'))
                        <!-- Switch to Customer route -->
                        <a href="{{ route('switchRole', ['role' => 'customer']) }}">Switch to Customer</a>
                    @elseif(auth()->user()->hasRole('customer'))
                        <!-- Switch to Artist route -->
                        <a href="{{ route('switchRole', ['role' => 'artist']) }}">Switch to Artist</a>
                    @endif
                </div>
            </div>

            <!-- Logout Form -->
<form action="{{ route('logout') }}" method="POST" style="display: inline;">
    @csrf
    <button type="submit" class="nav-link-button">Logout</button>


</form>
<!-- Cart Button for Customers -->
            @if(auth()->user()->hasRole('customer'))
                <a href="{{ route('cart.index') }}" class=""nav-link-button"">View Cart</a>
            @endif
        @else
            <a href="{{ route('login') }}">Login</a>
            <a href="{{ route('register') }}">Register</a>
        @endif
    </div>
</nav>




    <!-- Header Section -->
    <header class="header" id="home">
        <div class="text-content">
            <h1>Art Meets Passion</h1>
            <p>
                A vibrant online marketplace dedicated to connecting talented artists with art lovers worldwide. 
                Whether you're an artist looking to showcase your work or a customer searching for the perfect piece 
                of art, we provide a seamless, creative space for both.
            </p>
            <a href="#about" class="btn">Find Out More</a>
        </div>
        <div class="image-content">
        <img src="/images/slider-icon.png" alt="Paints Background" class="icon-image">
    </div>
    </header>

    <!-- Content Section -->
    <section class="content" id="about">
        <h2>Welcome to QALA</h2>
        <p>
            Explore a world of creativity where artists and art lovers unite. Our platform bridges the gap between 
            inspiration and creation, offering a diverse collection of artwork to suit every taste.
        </p>
    </section>

    <!-- Manage Section -->
    <section class="manage">
        <img src="/images/left-image.png" alt="Manage Art">
        <div class="text">
            <h2>Manage, Sell, and Showcase Your Art with Ease</h2>
            <p>As an artist, showcase your portfolio effortlessly by uploading your artwork to our platform. Track your sales and monitor real-time analytics through your personal dashboard. Easily manage your profile, update your artwork, and respond to customers.</p>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <h2>Why Choose QALA?</h2>
        <div class="feature-grid">
            <div class="feature">
                <img src="/images/about-icon-01.png" alt="User Friendly">
                <h3>User-Friendly Experience</h3>
                <p>Easy navigation for discovering art, managing profiles, and completing transactions.</p>
            </div>
            <div class="feature">
                <img src="/images/about-icon-02.png" alt="Secure">
                <h3>Secure and Reliable</h3>
                <p>Ensuring safe payments and data protection for peace of mind while buying or selling art.</p>
            </div>
            <div class="feature">
                <img src="/images/about-icon-03.png" alt="Global Reach">
                <h3>Empowering Creativity Globally</h3>
                <p>Helping artists reach global audiences and providing customers with personalized art.</p>
            </div>
        </div>
    </section>

    <!-- Contact Us Section -->
    <h2 class="contact-heading">Contact Us</h2>
    <section class="section" id="contact-us">
        <div class="container-fluid">
            <div class="row">
                <!-- Contact Form Start -->
                <form id="contact" action="{{ route('contact.send') }}" method="post">
    @csrf
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <input name="name" type="text" id="name" placeholder="Full Name" required="" class="contact-field">
        </div>
        <div class="col-md-6 col-sm-12">
            <input name="email" type="text" id="email" placeholder="E-mail" required="" class="contact-field">
        </div>
        <div class="col-lg-12">
            <textarea name="message" rows="6" id="message" placeholder="Your Message" required="" class="contact-field"></textarea>
        </div>
        <div class="col-lg-12">
            <button type="submit" id="form-submit" class="main-button">Send It</button>
        </div>
    </div>
</form>

                <!-- Contact Form End -->
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer">
        &copy; 2024 QALA. All Rights Reserved.
        </div>
    </footer>
</body>
</html>
