<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ComparisonController extends Controller
{
    public function index()
    {
        $ids = Session::get('comparison_items', []);
        $meals = Product::with('restaurant', 'category')
            ->whereIn('id', $ids)
            ->get();

        return view('compare.index', compact('meals'));
    }

    public function add(Request $request)
    {
        $ids = Session::get('comparison_items', []);
        
        if (count($ids) >= 4) {
            return response()->json(['status' => 'error', 'message' => 'Max 4 items allowed for comparison.']);
        }

        if (!in_array($request->meal_id, $ids)) {
            $ids[] = $request->meal_id;
            Session::put('comparison_items', $ids);
        }

        return response()->json(['status' => 'success', 'count' => count($ids)]);
    }

    public function remove(Request $request)
    {
        $ids = Session::get('comparison_items', []);
        
        if (($key = array_search($request->meal_id, $ids)) !== false) {
            unset($ids[$key]);
            Session::put('comparison_items', array_values($ids));
        }

        return redirect()->back()->with('success', 'Item removed from comparison.');
    }
}
