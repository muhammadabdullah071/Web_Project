<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Restaurant;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Auto-correct any legacy broken unsplash links in existing seeded database
        Product::where('image', 'https://images.unsplash.com/photo-1546241072-48010ad28c2c?q=80&w=1000')
            ->update(['image' => 'https://images.unsplash.com/photo-1600891964599-f61ba0e24092?q=80&w=1000']);

        $user = auth()->user();
        
        if ($user && $user->role === 'owner') {
            $restaurantIds = Restaurant::where('owner_id', $user->id)->pluck('id')->toArray();
            
            $stats = [
                'total_revenue' => Order::whereIn('restaurant_id', $restaurantIds)->where('status', '!=', 'cancelled')->sum('total'),
                'total_orders' => Order::whereIn('restaurant_id', $restaurantIds)->count(),
                'active_restaurants' => count($restaurantIds),
                'total_users' => User::where('role', 'customer')->count(),
                'pending_orders' => Order::whereIn('restaurant_id', $restaurantIds)->where('status', 'pending')->count(),
            ];

            $recentOrders = Order::whereIn('restaurant_id', $restaurantIds)
                ->with('user', 'restaurant')
                ->latest()
                ->take(10)
                ->get();
            $topRestaurants = Restaurant::whereIn('id', $restaurantIds)->get();
        } else {
            // Admin
            $stats = [
                'total_revenue' => Order::where('status', '!=', 'cancelled')->sum('total'),
                'total_orders' => Order::count(),
                'active_restaurants' => Restaurant::where('is_active', true)->count(),
                'total_users' => User::count(),
                'pending_orders' => Order::where('status', 'pending')->count(),
            ];

            $recentOrders = Order::with('user', 'restaurant')->latest()->take(10)->get();
            $topRestaurants = Restaurant::orderBy('rating', 'desc')->take(5)->get();
        }

        return view('admin.dashboard', compact('stats', 'recentOrders', 'topRestaurants'));
    }

    public function restaurants()
    {
        $restaurants = Restaurant::with('owner')->latest()->paginate(10);
        return view('admin.restaurants.index', compact('restaurants'));
    }

    public function foodItems()
    {
        $foodItems = Product::with('restaurant', 'category')->latest()->paginate(15);
        return view('admin.products.index', compact('foodItems'));
    }

    public function riders()
    {
        if (auth()->user()->role === 'owner') {
            abort(403, 'Unauthorized action.');
        }
        $riders = User::where('role', 'rider')->latest()->paginate(10);
        return view('admin.riders.index', compact('riders'));
    }

    public function customers()
    {
        if (auth()->user()->role === 'owner') {
            abort(403, 'Unauthorized action.');
        }
        $customers = User::where('role', 'customer')->latest()->paginate(10);
        return view('admin.customers.index', compact('customers'));
    }

    public function coupons()
    {
        if (auth()->user()->role === 'owner') {
            abort(403, 'Unauthorized action.');
        }
        return view('admin.coupons.index');
    }
}
