<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $wishlists = Wishlist::with('product')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('wishlist.index', compact('wishlists'));
    }

    public function toggle($productId)
    {
        $existing = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();

        if ($existing) {
            $existing->delete();
            return redirect()->back()->with('success', 'Removed from wishlist.');
        }

        Wishlist::create([
            'user_id' => Auth::id(),
            'product_id' => $productId,
        ]);

        return redirect()->back()->with('success', 'Added to wishlist!');
    }
}
