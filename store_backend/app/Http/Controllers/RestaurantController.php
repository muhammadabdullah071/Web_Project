<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function index(Request $request)
    {
        $query = Restaurant::where('is_active', true);

        // Save and filter by location if provided
        if ($request->has('location') && !empty($request->location)) {
            $location = $request->location;
            session(['user_city' => $location]);
            
            // Try strict sector/address matching first
            $strictCount = (clone $query)->where('address', 'like', "%$location%")->count();
            
            if ($strictCount >= 3) {
                $query->where('address', 'like', "%$location%");
            } else {
                // Parse city fallback (e.g. "F-7 Markaz, Islamabad" -> "Islamabad")
                $parts = explode(',', $location);
                $city = trim(end($parts));
                if (!empty($city)) {
                    $query->where(function($q) use ($location, $city) {
                        $q->where('address', 'like', "%$city%")
                          ->orWhere('name', 'like', "%$location%")
                          ->orWhere('description', 'like', "%$location%");
                    });
                }
            }
        }

        // Dynamic check for cuisine_type presence to support custom user databases
        $hasCuisineType = \Illuminate\Support\Facades\Schema::hasColumn('restaurants', 'cuisine_type');

        if ($request->has('categories') && is_array($request->categories) && count($request->categories) > 0) {
            $categoryIds = $request->categories;
            $categoryNames = Category::whereIn('id', $categoryIds)->pluck('name');

            $query->where(function($q) use ($categoryIds, $categoryNames, $hasCuisineType) {
                // 1. Relational filter: Show restaurants that actually offer products in the selected categories
                $q->whereHas('products', function($pq) use ($categoryIds) {
                    $pq->whereIn('category_id', $categoryIds);
                });

                // 2. Soft-match fallback: Show restaurants whose names or descriptions match the category names
                foreach ($categoryNames as $catName) {
                    $q->orWhere('name', 'like', "%$catName%")
                      ->orWhere('description', 'like', "%$catName%");
                      
                    if ($hasCuisineType) {
                        $q->orWhere('cuisine_type', 'like', "%$catName%");
                    }
                }
            });
        }

        if ($request->has('rating') && !empty($request->rating)) {
            $query->where('rating', '>=', floatval($request->rating));
        }

        if ($request->has('time') && !empty($request->time)) {
            $query->where('delivery_time', '<=', intval($request->time));
        }

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search, $hasCuisineType) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%")
                  ->orWhereHas('products', function($pq) use ($search) {
                      $pq->where('name', 'like', "%$search%")
                        ->orWhere('description', 'like', "%$search%");
                  });

                if ($hasCuisineType) {
                    $q->orWhere('cuisine_type', 'like', "%$search%");
                }
            });
        }

        $restaurants = $query->latest()->simplePaginate(12);
        $categories = Category::where('is_active', true)->get();

        return view('restaurants.index', compact('restaurants', 'categories'));
    }

    public function show($slug)
    {
        $restaurant = Restaurant::where('slug', $slug)->firstOrFail();
        
        // Get categorized menu
        $menu = Product::where('restaurant_id', $restaurant->id)
            ->where('is_available', true)
            ->get()
            ->groupBy(function($item) {
                return $item->category->name;
            });

        return view('restaurants.show', compact('restaurant', 'menu'));
    }
}
