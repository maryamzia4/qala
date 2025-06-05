<?php

// web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArtistProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

// Route for the landing page
Route::get('/', function () {
    return view('landing');
});

Route::get('/home', function () {
    return redirect()->route('dashboard');
})->name('home');


// Authenticated routes with middleware for verification
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard Route (For authenticated users)
    

Route::get('/dashboard', function () {
    if (Auth::check() && Auth::user()->role === 'admin') {
        return redirect()->route('admin'); // admin route
    }

    return view('landing'); // normal dashboard or landing view for other roles
})->name('dashboard');

    
    // Artist Profile Routes (accessed by authenticated users, regardless of role)
    Route::get('/artist/{userId}', [ArtistProfileController::class, 'show'])->name('artist-profile.show');
    Route::get('/artist-profile/edit', [ArtistProfileController::class, 'edit'])->name('artist-profile.edit');
    Route::put('/artist-profile', [ArtistProfileController::class, 'update'])->name('artist-profile.update');
    Route::get('/artist-profiles', [ArtistProfileController::class, 'index'])->name('artist-profile.index');
    
    // Product Routes (accessible by authenticated users, including customers)
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    
    // Switch Role Route (for switching roles)
    Route::get('/switch-role/{role}', [UserController::class, 'switchRole'])->name('switchRole');
});

// Route to switch roles (accessible by authenticated users)
Route::get('/switch-role/{role}', [UserController::class, 'switchRole'])->name('switchRole')->middleware('auth');

use App\Http\Controllers\CartController;

// Cart Routes
Route::middleware('auth')->group(function() {
    Route::get('cart', [CartController::class, 'index'])->name('cart.index');  // View cart
    Route::post('cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');  // Add product to cart
    Route::delete('cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');  // Remove product from cart
    Route::patch('cart/update/{id}', [CartController::class, 'updateCart'])->name('cart.update');  // Update product quantity
});

use App\Http\Controllers\CheckoutController;

Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
    // Define the route for the success callback
Route::get('checkout/success/{commissionId}', [CheckoutController::class, 'commissionSuccess'])->name('checkout.commissionSuccess');

// 
Route::get('/checkout/form', [CheckoutController::class, 'showForm'])->name('checkout.form');
Route::post('/checkout/form', [CheckoutController::class, 'handleForm']);

});

use App\Http\Controllers\OrderController;

Route::middleware('auth')->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
});

use App\Http\Controllers\RecommendationController;

Route::get('/recommend/{userId}', [RecommendationController::class, 'getRecommendations']);

use App\Http\Controllers\CommissionController;

Route::middleware('auth')->group(function () {
    
    // Form to create a commission request to a specific artist
    Route::get('/commissions/create/{artist_id}', [CommissionController::class, 'create'])->name('commissions.create');

    // Store a new commission request
    Route::post('/commissions/store', [CommissionController::class, 'store'])->name('commissions.store');

    // View all commissions received by the logged-in artist
    Route::get('/commissions', [CommissionController::class, 'index'])->name('commissions.index');

    // View a single commission (for artist to see full details)
    Route::get('/commissions/{id}', [CommissionController::class, 'show'])->name('commissions.show');

    // Respond to a commission (accept or reject)
    Route::post('/commissions/respond/{id}', [CommissionController::class, 'respond'])->name('commissions.respond');

    
});
Route::middleware(['auth', 'role:artist'])->group(function () {
    Route::post('/commissions/{id}/approve', [CommissionController::class, 'approve'])->name('commissions.approve');
    Route::post('/commissions/{id}/reject', [CommissionController::class, 'rejected'])->name('commissions.reject');
    Route::post('/commissions/{id}/ready', [CommissionController::class, 'markReady'])->name('commissions.markReady');
});


use App\Http\Middleware\Admin;
use App\Http\Controllers\AdminDashboardController;

Route::middleware([Admin::class])->get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin');
Route::get('/admin/artists', [AdminDashboardController::class, 'allArtists'])->name('admin.artists')->middleware('auth');
//Route::get('/admin/products', [AdminDashboardController::class, 'allProducts'])->name('admin.products')->middleware('auth');
Route::get('/admin/products', [AdminDashboardController::class, 'allProducts'])
    ->name('admin.products')
    ->middleware('auth');
Route::get('/admin/custom-requests', [AdminDashboardController::class, 'allCustomRequests'])->name('admin.custom.requests')->middleware('auth');



Route::post('/checkout/commission/{commission}', [CheckoutController::class, 'commissionCheckout'])->name('checkout.commissionCheckout');


Route::post('/commissions/{id}/set-price-approve', [CommissionController::class, 'setPriceAndApprove'])->name('commissions.setPriceAndApprove');
Route::post('/commissions/{id}/mark-ready', [CommissionController::class, 'markReady'])->name('commissions.markReady');
Route::post('/commissions/{id}/mark-delivered', [CommissionController::class, 'markDelivered'])->name('commissions.markDelivered');
Route::get('/customer/commissions', [CommissionController::class, 'customerRequests'])->name('commissions.customer');
Route::post('/commissions/{id}/payment-complete', [CommissionController::class, 'markAsPaid'])->name('commissions.markAsPaid');

use App\Http\Controllers\ReviewController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/product/{product}/review', [ReviewController::class, 'storeProductReview'])->name('review.product');
    Route::delete('/reviews/{id}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

});

use App\Http\Controllers\ContactUsController;

Route::post('/contact-us', [ContactUsController::class, 'send'])->name('contact.send');


Route::post('/interactions', [InteractionController::class, 'store'])->name('interactions.store');
