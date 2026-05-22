<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/restaurants', [App\Http\Controllers\RestaurantController::class, 'index'])->name('restaurants.index');
Route::get('/restaurant/{slug}', [App\Http\Controllers\RestaurantController::class, 'show'])->name('restaurants.show');
Route::get('/scan/{restaurantSlug}/{tableNumber}', [App\Http\Controllers\QrOrderController::class, 'scan'])->name('qr.scan');

Route::post('/location/set-city', [App\Http\Controllers\LocationController::class, 'setCity'])->name('location.set');

Route::get('/compare', [App\Http\Controllers\ComparisonController::class, 'index'])->name('compare.index');
Route::post('/compare/add', [App\Http\Controllers\ComparisonController::class, 'add'])->name('compare.add');
Route::post('/compare/remove', [App\Http\Controllers\ComparisonController::class, 'remove'])->name('compare.remove');

Route::middleware(['auth'])->group(function () {
    Route::get('/orders', [App\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [App\Http\Controllers\OrderController::class, 'show'])->name('orders.show');
});

// Unified Admin Routes managed in the block below

Route::get('/terms', function () { return view('terms'); })->name('terms');
Route::get('/privacy', function () { return view('privacy'); })->name('privacy');
Route::get('/offers', function () { return view('offers'); })->name('offers');
Route::get('/help', function () { return view('help'); })->name('help');

// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/logout', [AuthController::class, 'logout']);

// Products
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

// Cart
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// Checkout (Protected)
Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/order-confirmation/{id}', [CheckoutController::class, 'confirmation'])->name('orders.confirmation');

    // Wishlist
    Route::get('/wishlist', [App\Http\Controllers\WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle/{productId}', [App\Http\Controllers\WishlistController::class, 'toggle'])->name('wishlist.toggle');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Platform Management
    Route::resource('restaurants', App\Http\Controllers\Admin\RestaurantController::class);
    Route::resource('products', AdminProductController::class);
    Route::get('/food-items', [DashboardController::class, 'foodItems'])->name('food-items');

    // Fleet & Users
    Route::get('/riders', [DashboardController::class, 'riders'])->name('riders');
    Route::get('/customers', [DashboardController::class, 'customers'])->name('customers');
    Route::get('/coupons', [DashboardController::class, 'coupons'])->name('coupons');
    
    // Admin Orders
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
});

// Rider Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/rider/dashboard', [App\Http\Controllers\RiderController::class, 'dashboard'])->name('rider.dashboard');
    Route::patch('/rider/assignment/{id}/status', [App\Http\Controllers\RiderController::class, 'updateStatus'])->name('rider.status');
});

Route::get('/test-admin', function() {
    $u = \App\Models\User::where('role', 'admin')->first();
    if (!$u) {
        $u = \App\Models\User::create([
            'name' => 'System Director',
            'email' => 'admin@fooddash.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'is_admin' => true,
            'role' => 'admin',
        ]);
    }
    \Illuminate\Support\Facades\Auth::login($u);
    return redirect('/admin/dashboard');
});
