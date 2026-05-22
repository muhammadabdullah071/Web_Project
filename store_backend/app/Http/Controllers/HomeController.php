<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function index()
    {
        $userCity = Session::get('user_city', 'Islamabad');

        // 1. Trending Near You (City-Aware with smart fallback)
        $trendingNearYou = Restaurant::where('is_active', true)
            ->where('address', 'LIKE', "%{$userCity}%")
            ->orderBy('rating', 'desc')
            ->take(8)
            ->get();
            
        if ($trendingNearYou->count() < 4) {
            $parts = explode(',', $userCity);
            $city = trim(end($parts));
            if (empty($city)) {
                $city = 'Islamabad';
            }
            $trendingNearYou = Restaurant::where('is_active', true)
                ->where('address', 'LIKE', "%{$city}%")
                ->orderBy('rating', 'desc')
                ->take(8)
                ->get();
        }

        // 2. Popular Cuisines (Categories)
        $categories = Category::all();

        // 3. Recommended Meals (Personalized/Featured)
        $featuredMeals = Product::with('restaurant')
            ->where('is_featured', true)
            ->where('is_available', true)
            ->inRandomOrder()
            ->take(12)
            ->get();
            
        // 4. Budget Friendly (Under $1000)
        $budgetMeals = Product::with('restaurant')
            ->where('price', '<', 1000)
            ->where('is_available', true)
            ->take(8)
            ->get();

        // 5. New Arrivals
        $newRestaurants = Restaurant::where('is_active', true)
            ->latest()
            ->take(8)
            ->get();

        // 6. Top Rated Items
        $topRatedMeals = Product::with('restaurant')
            ->where('is_available', true)
            ->take(8)
            ->get();

        // Quick Comparison Count
        $compareCount = count(Session::get('comparison_items', []));

        return view('home', compact(
            'trendingNearYou', 
            'categories', 
            'featuredMeals', 
            'budgetMeals',
            'newRestaurants',
            'topRatedMeals',
            'compareCount', 
            'userCity'
        ));
    }
}
