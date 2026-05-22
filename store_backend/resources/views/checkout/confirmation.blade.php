@extends('layouts.app')

@section('content')
<div class="container py-5" style="min-height: 80vh;">
    <div class="row justify-content-center">
        <div class="col-lg-8 text-center mt-5">
            <!-- Glass Shine Container -->
            <div class="glass-card p-5 rounded-4 shadow-lg position-relative overflow-hidden" style="border: 1px solid var(--accent-orange); box-shadow: 0 0 40px rgba(255, 122, 0, 0.15) !important;">
                
                <!-- Success Icon -->
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-4" style="width: 100px; height: 100px; background: rgba(255, 122, 0, 0.1); border: 2px solid var(--accent-orange); box-shadow: 0 0 20px rgba(255, 122, 0, 0.4);">
                    <i class="fa-solid fa-check text-orange" style="font-size: 3rem;"></i>
                </div>

                <h1 class="display-4 fw-bold text-white mb-3">Order <span class="text-orange">Confirmed!</span></h1>
                <p class="text-secondary fs-5 mb-5">Thank you, <span class="text-white">{{ $order->first_name }}</span>. Your delicious food is being prepared.</p>

                <div class="bg-dark bg-opacity-50 rounded-4 p-4 text-start mb-5 border border-glass mx-auto" style="max-width: 500px;">
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom border-secondary border-opacity-25">
                        <span class="text-secondary">Order Reference</span>
                        <span class="text-white font-monospace fw-bold fs-5">{{ $order->order_number }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom border-secondary border-opacity-25">
                        <span class="text-secondary">Total Amount</span>
                        <span class="text-orange fw-bold fs-4">PKR {{ number_format($order->total) }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-secondary">Payment Status</span>
                        <span class="badge rounded-pill bg-success bg-opacity-25 text-success border border-success px-3 py-2 fs-6">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </div>
                </div>

                <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center mt-4 position-relative" style="z-index: 10;">
                    <a href="{{ route('orders.index') }}" class="btn py-3 px-5 fs-5 rounded-pill shadow-sm text-white d-flex align-items-center justify-content-center" style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.2); transition: all 0.3s ease;" onmouseover="this.style.background='rgba(255,255,255,0.1)'" onmouseout="this.style.background='rgba(255,255,255,0.05)'">
                        <i class="fa-solid fa-receipt me-2 text-orange"></i> View Order Details
                    </a>
                    <a href="{{ route('home') }}" class="btn btn-checkout-premium py-3 px-5 fs-5 rounded-pill shadow-lg text-white text-decoration-none d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-house me-2"></i> Back to Home
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-checkout-premium {
        background: linear-gradient(45deg, #FF7A00, #FF4500);
        border: none;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    .btn-checkout-premium:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 25px rgba(255, 122, 0, 0.4) !important;
        background: linear-gradient(45deg, #FF8C00, #FF5500);
    }
</style>
@endsection
