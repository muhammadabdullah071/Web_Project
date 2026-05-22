<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LocationController extends Controller
{
    public function setCity(Request $request)
    {
        $request->validate([
            'city' => 'required|string|max:255',
            'lat' => 'nullable|numeric',
            'lng' => 'nullable|numeric',
        ]);

        Session::put('user_city', $request->city);
        Session::put('user_lat', $request->lat);
        Session::put('user_lng', $request->lng);

        return response()->json([
            'status' => 'success',
            'city' => $request->city
        ]);
    }
}
