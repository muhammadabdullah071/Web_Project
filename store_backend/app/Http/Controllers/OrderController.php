<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('restaurant')
            ->latest()
            ->get();
            
        return view('orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with('restaurant', 'items.product')
            ->where('user_id', Auth::id())
            ->findOrFail($id);
            
        return view('orders.show', compact('order'));
    }
}
