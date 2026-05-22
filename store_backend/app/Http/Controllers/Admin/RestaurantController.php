<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RestaurantController extends Controller
{
    public function index()
    {
        $query = Restaurant::with('owner');
        if (auth()->user()->role === 'owner') {
            $query->where('owner_id', auth()->id());
        }
        $restaurants = $query->latest()->paginate(15);
        return view('admin.restaurants.index', compact('restaurants'));
    }

    public function create()
    {
        if (auth()->user()->role === 'owner') {
            $owners = collect([auth()->user()]);
        } else {
            $owners = User::where('role', User::ROLE_OWNER)->get();
        }
        return view('admin.restaurants.create', compact('owners'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role === 'owner') {
            $request->merge(['owner_id' => auth()->id()]);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'owner_id' => 'required|exists:users,id',
            'delivery_time' => 'required|integer|min:0',
            'min_order' => 'required|numeric|min:0',
            'address' => 'required|string',
            'image' => 'nullable|url',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        $data['rating'] = 4.5;
        $data['is_active'] = $request->has('is_active');

        Restaurant::create($data);
        return redirect()->route('admin.restaurants.index')->with('success', 'Restaurant added to the platform network.');
    }

    public function edit($id)
    {
        $restaurant = Restaurant::findOrFail($id);
        if (auth()->user()->role === 'owner' && $restaurant->owner_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
        $owners = User::where('role', User::ROLE_OWNER)->get();
        return view('admin.restaurants.edit', compact('restaurant', 'owners'));
    }

    public function update(Request $request, $id)
    {
        $restaurant = Restaurant::findOrFail($id);
        if (auth()->user()->role === 'owner' && $restaurant->owner_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'delivery_time' => 'required|integer|min:0',
            'min_order' => 'required|numeric|min:0',
            'address' => 'required|string',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        $restaurant->update($data);
        return redirect()->route('admin.restaurants.index')->with('success', 'Restaurant configuration updated in real-time.');
    }

    public function destroy($id)
    {
        $restaurant = Restaurant::findOrFail($id);
        if (auth()->user()->role === 'owner' && $restaurant->owner_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
        $restaurant->delete();
        return redirect()->route('admin.restaurants.index')->with('success', 'Restaurant removed from platform network.');
    }
}
