<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RiderAssignment;
use App\Models\Order;

class RiderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        if (Auth::user()->role !== 'rider') {
            return redirect('/')->with('error', 'Access denied.');
        }

        $activeAssignment = RiderAssignment::with(['order.restaurant', 'order.user'])
            ->where('rider_id', Auth::id())
            ->whereIn('status', ['assigned', 'picked_up'])
            ->latest()
            ->first();

        $completedCount = RiderAssignment::where('rider_id', Auth::id())
            ->where('status', 'delivered')
            ->count();

        return view('rider.dashboard', compact('activeAssignment', 'completedCount'));
    }

    public function updateStatus(Request $request, $id)
    {
        if (Auth::user()->role !== 'rider') {
            return redirect('/')->with('error', 'Access denied.');
        }

        $assignment = RiderAssignment::where('rider_id', Auth::id())->findOrFail($id);
        $request->validate([
            'status' => 'required|in:picked_up,delivered'
        ]);

        $assignment->update([
            'status' => $request->status
        ]);

        // Update corresponding order status
        if ($request->status === 'picked_up') {
            $assignment->order->update([
                'status' => 'out_for_delivery'
            ]);
        } elseif ($request->status === 'delivered') {
            $assignment->order->update([
                'status' => 'delivered',
                'payment_status' => 'paid'
            ]);
        }

        return redirect()->back()->with('success', 'Task status updated successfully!');
    }
}
