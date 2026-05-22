<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $cartItems = [];
        $subtotal = 0;

        foreach ($cart as $id => $item) {
            $product = Product::find($id);
            if ($product) {
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'total' => $product->display_price * $item['quantity'],
                ];
                $subtotal += $product->display_price * $item['quantity'];
            }
        }

        $shipping = $subtotal > 2000 ? 0 : 150;
        $platform_fee = 500;
        $total = $subtotal + $shipping + $platform_fee;

        return view('checkout.index', compact('cartItems', 'subtotal', 'shipping', 'platform_fee', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'zip_code' => 'nullable|string',
            'payment_method' => 'required|in:cod,card',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Auto-fill missing fields
        $request->merge([
            'email' => $request->email ?? Auth::user()->email,
            'zip_code' => $request->zip_code ?? '44000',
        ]);

        DB::beginTransaction();

        try {
            $subtotal = 0;
            $orderItems = [];
            $restaurant_id = null;

            foreach ($cart as $id => $item) {
                $product = Product::findOrFail($id);
                $price = $product->display_price;
                $total = $price * $item['quantity'];
                $subtotal += $total;

                if (!$restaurant_id) {
                    $restaurant_id = $product->restaurant_id;
                }

                $orderItems[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'price' => $price,
                    'quantity' => $item['quantity'],
                    'total' => $total,
                ];

                // Decrease stock
                $product->decrement('quantity', $item['quantity']);
            }

            $shipping = $subtotal > 2000 ? 0 : 150;
            $platform_fee = 500;

            $order = Order::create([
                'user_id' => Auth::id(),
                'restaurant_id' => $restaurant_id,
                'order_number' => Order::generateOrderNumber(),
                'subtotal' => $subtotal,
                'shipping' => $shipping,
                'platform_fee' => $platform_fee,
                'total' => $subtotal + $shipping + $platform_fee,
                'status' => 'pending',
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_method === 'cod' ? 'unpaid' : 'paid',
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'zip_code' => $request->zip_code,
                'notes' => $request->notes,
            ]);

            foreach ($orderItems as $item) {
                $order->items()->create($item);
            }

            session()->forget('cart');
            DB::commit();

            return redirect()->route('orders.confirmation', $order->id)
                ->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            \Illuminate\Support\Facades\Log::error('Checkout Error: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function confirmation($id)
    {
        $order = Order::with('items')->where('user_id', Auth::id())->findOrFail($id);
        return view('checkout.confirmation', compact('order'));
    }
}
