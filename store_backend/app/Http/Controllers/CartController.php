<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $cartItems = [];
        $subtotal = 0;
        $cleanCart = [];

        foreach ($cart as $id => $item) {
            $product = Product::with('restaurant')->find($id);
            if ($product) {
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'total' => $product->display_price * $item['quantity'],
                ];
                $subtotal += $product->display_price * $item['quantity'];
                $cleanCart[$id] = $item;
            }
        }

        if (count($cart) !== count($cleanCart)) {
            session()->put('cart', $cleanCart);
        }

        $activeOrders = collect();
        if (Auth::check()) {
            $activeOrders = Order::where('user_id', Auth::id())
                ->whereIn('status', ['pending', 'processing', 'dispatched', 'accepted', 'picked_up'])
                ->with('restaurant', 'items.product')
                ->latest()
                ->get();
        }

        return view('cart.index', compact('cartItems', 'subtotal', 'activeOrders'));
    }

    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);
        $qty = $request->input('quantity', 1);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $qty;
        } else {
            $cart[$id] = ['quantity' => $qty];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = max(1, (int)$request->input('quantity', 1));
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Cart updated!');
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);
        unset($cart[$id]);
        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Item removed from cart!');
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart.index')->with('success', 'Cart cleared!');
    }

    public function getCartCount()
    {
        $cart = session()->get('cart', []);
        $count = 0;
        if (!empty($cart)) {
            $validProductIds = Product::whereIn('id', array_keys($cart))->pluck('id')->toArray();
            foreach ($cart as $id => $item) {
                if (in_array($id, $validProductIds)) {
                    $count += $item['quantity'];
                }
            }
        }
        return $count;
    }
}
