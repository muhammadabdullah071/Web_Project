<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $query = Order::with('user')->latest();
        
        // Filter orders so Restaurant Owners only see their own
        if (auth()->user()->role === \App\Models\User::ROLE_OWNER) {
            $query->whereHas('restaurant', function($q) {
                $q->where('owner_id', auth()->id());
            });
        }
        
        $orders = $query->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['items', 'user'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:pending,preparing,processing,ready,out_for_delivery,shipped,delivered,cancelled']);

        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);

        // Automated Rider Dispatch Logic
        if (in_array($request->status, ['preparing', 'processing', 'ready', 'out_for_delivery', 'shipped'])) {
            // Find an available rider in the system (or create a generic one if none exist)
            $rider = \App\Models\User::firstOrCreate(
                ['email' => 'rider@fooddash.com'],
                [
                    'name' => 'Speedy Rider',
                    'password' => \Illuminate\Support\Facades\Hash::make('password'),
                    'role' => \App\Models\User::ROLE_RIDER ?? 'rider',
                    'phone' => '+92 311 9998887'
                ]
            );

            // Create or update the Rider Assignment to instantly notify the Rider app
            \App\Models\RiderAssignment::updateOrCreate(
                ['order_id' => $order->id],
                [
                    'rider_id' => $rider->id,
                    'status' => 'assigned',
                    'lat' => 33.6844, // Default Islamabad coordinates for the simulation
                    'lng' => 73.0479
                ]
            );
        }

        return redirect()->back()->with('success', 'Order status updated and Rider notified!');
    }
}
