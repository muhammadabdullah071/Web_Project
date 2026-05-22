@extends('layouts.app')

@section('title', 'Your Feast - FoodDash Premium')

@section('styles')
<style>
    .cart-header {
        background: linear-gradient(135deg, var(--bg-dark-2) 0%, var(--bg-dark-1) 100%);
        padding: 100px 0 40px;
        position: relative;
        overflow: hidden;
    }
    
    .cart-item {
        background: linear-gradient(145deg, rgba(255,255,255,0.03) 0%, rgba(255,255,255,0.01) 100%);
        border: 1px solid var(--glass-border);
        border-radius: 20px;
        padding: 20px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        transition: var(--transition-smooth);
    }
    .cart-item:hover {
        background: rgba(255,255,255,0.05);
        border-color: rgba(255,122,0,0.3);
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.5);
    }
    
    .cart-img {
        width: 100px; height: 100px;
        object-fit: cover;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    }
    
    .qty-control {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50px;
        padding: 5px 15px;
        border: 1px solid var(--glass-border);
        display: flex; align-items: center;
    }
    .qty-input {
        background: transparent;
        border: none;
        color: white;
        width: 40px;
        text-align: center;
        font-weight: 700;
        font-family: 'Poppins', sans-serif;
    }
    
    .summary-card {
        background: var(--glass-bg);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid var(--glass-border);
        border-radius: 30px;
        padding: 35px;
        position: sticky;
        top: 100px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.5);
    }
    
    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
        color: var(--text-secondary);
        font-size: 0.95rem;
    }
    .summary-total {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid var(--glass-border);
        font-family: 'Poppins', sans-serif;
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-primary);
    }
</style>
@endsection

@section('content')
<header class="cart-header">
    <div class="container" data-aos="fade-down">
        <h1 class="display-5 font-poppins text-white mb-2"><i class="fa-solid fa-bag-shopping text-orange me-3"></i>Your Order</h1>
        <p class="text-secondary fs-5">Review your selections before we start preparing your feast.</p>
    </div>
</header>

<div class="container py-5">
    @if(count($cartItems ?? []) > 0)
        <div class="row g-5">
            <!-- Cart Items -->
            <div class="col-lg-8" data-aos="fade-up" data-aos-delay="100">
                @foreach($cartItems as $item)
                    <div class="cart-item">
                        <img src="{{ $item['product']->display_image ?? 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?q=80&w=800' }}" class="cart-img me-4" alt="Food">
                        <div class="flex-grow-1">
                            <h4 class="font-poppins mb-1 text-white">{{ $item['product']->name ?? 'Gourmet Meal' }}</h4>
                            <p class="text-secondary small mb-2"><i class="fa-solid fa-utensils me-1 text-orange"></i> {{ $item['product']->restaurant->name ?? 'Premium Partner' }}</p>
                            <h5 class="text-orange font-poppins mb-0">PKR {{ number_format($item['product']->display_price ?? 0, 0) }}</h5>
                        </div>
                        
                        <div class="d-flex flex-column align-items-end gap-3">
                            <form action="{{ route('cart.remove', $item['product']->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-link text-muted hover-orange p-0 text-decoration-none"><i class="fa-solid fa-xmark fs-5"></i></button>
                            </form>
                            
                            <form action="{{ route('cart.update', $item['product']->id) }}" method="POST" class="qty-control">
                                @csrf
                                @method('PATCH')
                                <button type="submit" name="action" value="decrease" class="btn btn-sm text-secondary p-0 border-0" onclick="this.nextElementSibling.stepDown();"><i class="fa-solid fa-minus"></i></button>
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="qty-input" readonly>
                                <button type="submit" name="action" value="increase" class="btn btn-sm text-secondary p-0 border-0" onclick="this.previousElementSibling.stepUp();"><i class="fa-solid fa-plus"></i></button>
                            </form>
                        </div>
                    </div>
                @endforeach
                
                <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top border-secondary border-opacity-25">
                    <a href="{{ route('restaurants.index') }}" class="btn btn-glass-outline rounded-pill px-4">
                        <i class="fa-solid fa-arrow-left me-2"></i> Add More Items
                    </a>
                    <form action="{{ route('cart.clear') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-link text-danger text-decoration-none small">
                            <i class="fa-solid fa-trash-can me-1"></i> Clear Cart
                        </button>
                    </form>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4" data-aos="fade-left" data-aos-delay="200">
                <div class="summary-card">
                    <h3 class="font-poppins mb-4">Order Summary</h3>
                    
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span class="text-white">PKR {{ number_format($subtotal ?? 0, 0) }}</span>
                    </div>
                    <div class="summary-row">
                        <span>Delivery Fee</span>
                        <span class="text-success fw-bold">FREE</span>
                    </div>
                    <div class="summary-row">
                        <span>Platform Fee</span>
                        <span class="text-white">PKR 500</span>
                    </div>
                    
                    <div class="summary-total">
                        <span>Total</span>
                        <span class="text-orange">PKR {{ number_format(($subtotal ?? 0) + 500, 0) }}</span>
                    </div>
                    
                    <a href="{{ route('checkout') }}" class="btn btn-premium w-100 py-3 mt-4 rounded-pill d-flex justify-content-between align-items-center px-4">
                        <span>Proceed to Checkout</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                    
                    <div class="mt-4 p-3 rounded-4xl bg-dark border border-secondary border-opacity-25">
                        <div class="d-flex align-items-center gap-3 mb-2 text-secondary small">
                            <i class="fa-solid fa-shield-halved text-success fs-5"></i>
                            <span>Secure Encrypted Checkout</span>
                        </div>
                        <div class="d-flex align-items-center gap-3 text-secondary small">
                            <i class="fa-solid fa-clock-rotate-left text-orange fs-5"></i>
                            <span>Estimated Delivery: 25-40 mins</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        @if(isset($activeOrders) && $activeOrders->count() > 0)
            <div class="row justify-content-center" data-aos="fade-up">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
                        <div>
                            <h2 class="font-poppins text-white fw-bold mb-1">Active <span class="text-orange">Feasts</span></h2>
                            <p class="text-secondary small mb-0">Follow your delicious preparation and delivery in real-time.</p>
                        </div>
                        <span class="badge bg-orange text-dark px-3 py-2 rounded-pill fw-bold animate-pulse" style="font-size:0.8rem; filter: drop-shadow(0 0 8px var(--accent-orange));"><i class="fa-solid fa-fire-burner me-1"></i> Live Preparing</span>
                    </div>

                    @foreach($activeOrders as $order)
                        <div class="glass-card p-4 rounded-4xl mb-4 border-glass" style="background: rgba(255, 255, 255, 0.02); border-radius: 24px; transition: all 0.3s ease;">
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center border-bottom border-secondary border-opacity-25 pb-3 mb-4 gap-3">
                                <div>
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <h4 class="text-white font-poppins fw-bold mb-0" style="font-size:1.15rem;">#{{ $order->order_number }}</h4>
                                        <span class="badge bg-orange bg-opacity-10 text-orange border border-orange border-opacity-20 rounded-pill px-2.5 py-1" style="font-size:0.65rem;">ACTIVE</span>
                                    </div>
                                    <p class="text-secondary small mb-0"><i class="fa-solid fa-utensils text-orange me-1"></i> {{ $order->restaurant->name ?? 'Premium Partner' }}</p>
                                </div>
                                <div class="text-md-end">
                                    <h4 class="text-orange font-poppins fw-bold mb-1" style="font-size:1.25rem;">PKR {{ number_format($order->total) }}</h4>
                                    <p class="text-secondary small mb-0">Placed {{ $order->created_at->diffForHumans() }}</p>
                                </div>
                            </div>

                            <!-- Interactive Progress Tracker -->
                            <div class="order-tracker mb-5 py-2 position-relative" style="margin-bottom: 2.5rem !important;">
                                <div class="tracker-steps d-flex justify-content-between position-relative">
                                    <!-- Back Connector Bar -->
                                    @php
                                        $progressWidth = '10%';
                                        if ($order->status == 'pending') $progressWidth = '15%';
                                        elseif ($order->status == 'processing') $progressWidth = '50%';
                                        elseif (in_array($order->status, ['dispatched', 'picked_up', 'accepted'])) $progressWidth = '85%';
                                        elseif (in_array($order->status, ['completed', 'delivered'])) $progressWidth = '100%';
                                    @endphp
                                    <div class="tracker-bar position-absolute w-100 bg-secondary bg-opacity-25 rounded" style="height:4px; top:18px; left:0; z-index:1;"></div>
                                    <div class="tracker-progress position-absolute bg-orange rounded" style="height:4px; top:18px; left:0; width: {{ $progressWidth }}; z-index:2; transition: width 1s ease-in-out; box-shadow: 0 0 10px var(--accent-orange);"></div>

                                    <!-- Step 1: Placed -->
                                    <div class="step-node text-center position-relative" style="z-index: 5; width: 80px;">
                                        <div class="node-icon rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2 {{ in_array($order->status, ['pending', 'processing', 'dispatched', 'accepted', 'picked_up', 'completed', 'delivered']) ? 'bg-orange text-dark shadow-orange' : 'bg-dark border border-secondary text-secondary' }}" style="width:40px; height:40px; transition: all 0.3s ease; box-shadow: {{ in_array($order->status, ['pending', 'processing', 'dispatched', 'accepted', 'picked_up', 'completed', 'delivered']) ? '0 0 12px var(--accent-orange)' : 'none' }};">
                                            <i class="fa-solid fa-receipt small"></i>
                                        </div>
                                        <span class="small font-poppins d-block text-nowrap" style="font-size:0.75rem; {{ in_array($order->status, ['pending', 'processing', 'dispatched', 'accepted', 'picked_up', 'completed', 'delivered']) ? 'color: #FFF; font-weight: 600;' : 'color: rgba(255,255,255,0.4);' }}">Order Placed</span>
                                    </div>

                                    <!-- Step 2: Preparing -->
                                    <div class="step-node text-center position-relative" style="z-index: 5; width: 80px;">
                                        <div class="node-icon rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2 {{ in_array($order->status, ['processing', 'dispatched', 'accepted', 'picked_up', 'completed', 'delivered']) ? 'bg-orange text-dark shadow-orange' : 'bg-dark border border-secondary text-secondary' }}" style="width:40px; height:40px; transition: all 0.3s ease; box-shadow: {{ in_array($order->status, ['processing', 'dispatched', 'accepted', 'picked_up', 'completed', 'delivered']) ? '0 0 12px var(--accent-orange)' : 'none' }};">
                                            <i class="fa-solid fa-fire-burner small text-nowrap"></i>
                                        </div>
                                        <span class="small font-poppins d-block text-nowrap" style="font-size:0.75rem; {{ in_array($order->status, ['processing', 'dispatched', 'accepted', 'picked_up', 'completed', 'delivered']) ? 'color: #FFF; font-weight: 600;' : 'color: rgba(255,255,255,0.4);' }}">Preparing Feast</span>
                                    </div>

                                    <!-- Step 3: On the Way -->
                                    <div class="step-node text-center position-relative" style="z-index: 5; width: 80px;">
                                        <div class="node-icon rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2 {{ in_array($order->status, ['dispatched', 'accepted', 'picked_up', 'completed', 'delivered']) ? 'bg-orange text-dark shadow-orange' : 'bg-dark border border-secondary text-secondary' }}" style="width:40px; height:40px; transition: all 0.3s ease; box-shadow: {{ in_array($order->status, ['dispatched', 'accepted', 'picked_up', 'completed', 'delivered']) ? '0 0 12px var(--accent-orange)' : 'none' }};">
                                            <i class="fa-solid fa-motorcycle small"></i>
                                        </div>
                                        <span class="small font-poppins d-block text-nowrap" style="font-size:0.75rem; {{ in_array($order->status, ['dispatched', 'accepted', 'picked_up', 'completed', 'delivered']) ? 'color: #FFF; font-weight: 600;' : 'color: rgba(255,255,255,0.4);' }}">On The Way</span>
                                    </div>
                                </div>
                            </div>

                            <!-- List of Items in the Active Order -->
                            <div class="mb-4 bg-black bg-opacity-25 rounded-4 p-3 border border-glass" style="border-radius: 16px;">
                                <h6 class="text-secondary small fw-bold tracking-widest text-uppercase mb-3" style="font-size:0.65rem; letter-spacing: 1.5px;">FEAST MENU</h6>
                                <div class="d-flex flex-column gap-2.5">
                                    @foreach($order->items as $item)
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="text-white small fw-bold">{{ $item->quantity }}x <span class="fw-normal text-secondary ms-1">{{ $item->product_name ?? 'Gourmet Selection' }}</span></span>
                                            <span class="text-white-50 small">PKR {{ number_format($item->price * $item->quantity) }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="d-flex flex-column flex-sm-row gap-3">
                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-premium flex-grow-1 py-3 rounded-pill d-flex align-items-center justify-content-center gap-2">
                                    <i class="fa-solid fa-location-crosshairs"></i> Live Track Order
                                </a>
                                <a href="{{ route('home') }}" class="btn btn-glass-outline px-4 py-3 rounded-pill text-white text-decoration-none text-center">
                                    Continue Shopping
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="text-center py-5 my-5" data-aos="zoom-in">
                <div class="mb-4">
                    <i class="fa-solid fa-basket-shopping text-secondary opacity-25" style="font-size: 8rem;"></i>
                </div>
                <h2 class="font-poppins text-white mb-3">Your cart is empty</h2>
                <p class="text-secondary fs-5 mb-5 max-w-md mx-auto">Looks like you haven't added anything to your cart yet. Discover amazing food from premium partners.</p>
                <a href="{{ route('restaurants.index') }}" class="btn btn-premium px-5 py-3 rounded-pill">
                    Explore Restaurants
                </a>
            </div>
        @endif
    @endif
</div>
@endsection
