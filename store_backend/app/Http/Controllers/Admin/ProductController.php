<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $query = Product::with(['category', 'restaurant']);
        if (auth()->user()->role === 'owner') {
            $query->whereHas('restaurant', function($q) {
                $q->where('owner_id', auth()->id());
            });
        }
        $products = $query->latest()->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        
        $query = Restaurant::query();
        if (auth()->user()->role === 'owner') {
            $query->where('owner_id', auth()->id());
        }
        $restaurants = $query->orderBy('name')->get();
        
        return view('admin.products.create', compact('categories', 'restaurants'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'             => 'required|string|max:255',
            'restaurant_id'    => 'required|exists:restaurants,id',
            'category_id'      => 'required|exists:categories,id',
            'price'            => 'required|numeric|min:0',
            'quantity'         => 'required|integer|min:0',
            'description'      => 'nullable|string',
            'image'            => 'nullable|image|max:4096',
            'image_url'        => 'nullable|url',
            'preparation_time' => 'nullable|integer|min:1',
        ]);

        if (auth()->user()->role === 'owner') {
            $restaurant = Restaurant::findOrFail($request->restaurant_id);
            if ($restaurant->owner_id !== auth()->id()) {
                abort(403, 'Unauthorized action.');
            }
        }

        $data = $request->except(['image', 'image_url']);
        $data['slug']        = Str::slug($request->name) . '-' . uniqid();
        $data['is_featured'] = $request->has('is_featured');
        $data['is_active']   = $request->has('is_active');

        // Priority: file upload > URL
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        } elseif ($request->filled('image_url')) {
            $data['image'] = $request->input('image_url');
        }

        Product::create($data);
        return redirect()->route('admin.food-items')->with('success', 'Menu item added successfully!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        if (auth()->user()->role === 'owner' && $product->restaurant && $product->restaurant->owner_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $categories = Category::where('is_active', true)->get();
        
        $query = Restaurant::query();
        if (auth()->user()->role === 'owner') {
            $query->where('owner_id', auth()->id());
        }
        $restaurants = $query->orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'categories', 'restaurants'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        if (auth()->user()->role === 'owner' && $product->restaurant && $product->restaurant->owner_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name'          => 'required|string|max:255',
            'restaurant_id' => 'required|exists:restaurants,id',
            'category_id'   => 'required|exists:categories,id',
            'price'         => 'required|numeric|min:0',
            'quantity'      => 'required|integer|min:0',
            'image'         => 'nullable|image|max:4096',
            'image_url'     => 'nullable|url',
        ]);

        if (auth()->user()->role === 'owner') {
            $restaurant = Restaurant::findOrFail($request->restaurant_id);
            if ($restaurant->owner_id !== auth()->id()) {
                abort(403, 'Unauthorized action.');
            }
        }

        $data = $request->except(['image', 'image_url']);
        $data['is_featured'] = $request->has('is_featured');
        $data['is_active']   = $request->has('is_active');

        // Priority: uploaded file > URL > keep existing
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        } elseif ($request->filled('image_url')) {
            $data['image'] = $request->input('image_url');
        }

        $product->update($data);
        return redirect()->route('admin.food-items')->with('success', 'Menu item updated successfully!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        if (auth()->user()->role === 'owner' && $product->restaurant && $product->restaurant->owner_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
        $product->delete();
        return redirect()->route('admin.food-items')->with('success', 'Product deleted!');
    }
}
