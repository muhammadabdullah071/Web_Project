<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\QrTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class QrOrderController extends Controller
{
    public function scan($restaurantSlug, $tableNumber)
    {
        $restaurant = Restaurant::where('slug', $restaurantSlug)->firstOrFail();
        
        // Save table info in session
        Session::put('qr_restaurant_id', $restaurant->id);
        Session::put('qr_table_number', $tableNumber);
        Session::put('is_dine_in', true);

        return redirect()->route('restaurants.show', $restaurant->slug)
            ->with('success', "Welcome to {$restaurant->name}! You are ordering from Table #{$tableNumber}.");
    }
}
