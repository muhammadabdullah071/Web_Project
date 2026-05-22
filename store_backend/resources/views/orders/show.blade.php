@extends('layouts.app')

@section('title', 'Order Tracking - FoodDash')

@section('content')
<section class="py-5 mt-5">
    <div class="container">
        <div class="row g-4">
            <!-- Tracking Timeline -->
            <div class="col-lg-5">
                <div class="glass-card p-4 h-100">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <h4 class="mb-1 fw-bold">Track <span class="text-orange">Order</span></h4>
                            <p class="text-muted small">Order ID: #FD-{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p>
                        </div>
                        <span class="badge bg-orange-light text-orange px-3 py-2 rounded-pill d-flex align-items-center gap-2" style="background: rgba(255, 92, 0, 0.1);">
                            <span class="live-dot-pulse"></span> Live Status
                        </span>
                    </div>
                    
                    <div class="tracking-timeline">
                        @php
                            $statuses = [
                                'pending' => ['icon' => 'fa-clipboard-list', 'title' => 'Order Confirmed', 'desc' => 'We have received your gourmet request.'],
                                'preparing' => ['icon' => 'fa-fire-burner', 'title' => 'Chef is Cooking', 'desc' => 'Your meal is being prepared with care.'],
                                'ready' => ['icon' => 'fa-box', 'title' => 'Packing Order', 'desc' => 'Sealing the flavors for delivery.'],
                                'out_for_delivery' => ['icon' => 'fa-motorcycle', 'title' => 'On the Way', 'desc' => 'Our rider is speeding to your door.'],
                                'delivered' => ['icon' => 'fa-house-circle-check', 'title' => 'Delivered', 'desc' => 'Flavor has arrived. Bon appétit!']
                            ];
                            $statusMap = [
                                'pending' => 'pending',
                                'processing' => 'preparing',
                                'preparing' => 'preparing',
                                'ready' => 'ready',
                                'out_for_delivery' => 'out_for_delivery',
                                'delivered' => 'delivered',
                                'completed' => 'delivered',
                                'cancelled' => 'cancelled'
                            ];
                            $currentStatus = $statusMap[$order->status] ?? $order->status;
                            $foundCurrent = false;
                        @endphp

                        @foreach($statuses as $key => $info)
                            @php
                                $isCompleted = !$foundCurrent;
                                if($currentStatus == $key) $foundCurrent = true;
                                $isActive = $currentStatus == $key;
                            @endphp
                            <div class="timeline-item {{ $isActive ? 'active' : ($isCompleted ? 'completed' : '') }}">
                                <div class="timeline-icon">
                                    <i class="fa-solid {{ $info['icon'] }}"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6 class="mb-0 fw-bold">{{ $info['title'] }}</h6>
                                    <small class="{{ $isActive ? 'text-white' : 'text-muted' }} d-block">{{ $info['desc'] }}</small>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-5 p-3 rounded-4 bg-glass border border-glass">
                        <div class="d-flex align-items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name=Rider&background=FF5C00&color=fff" class="rounded-circle border border-orange border-2" style="width: 50px;">
                            <div class="flex-grow-1">
                                <h6 class="mb-0 fw-bold">Ahmad Abdullah</h6>
                                <small class="text-muted">Top Rated Delivery Hero</small>
                            </div>
                            <a href="tel:+923094586205" class="btn btn-orange btn-sm rounded-circle" style="width: 35px; height: 35px; padding: 0; display: flex; align-items: center; justify-content: center;">
                                <i class="fa-solid fa-phone fs-6"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Invoice Details -->
            <div class="col-lg-7">
                <div class="glass-card p-0 overflow-hidden h-100 d-flex flex-column">
                    <div class="p-4 bg-glass border-bottom border-glass">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold"><i class="fa-solid fa-file-invoice text-orange me-2"></i> Order Summary</h5>
                            <button onclick="window.print()" class="btn btn-glass btn-sm rounded-pill"><i class="fa-solid fa-print me-2"></i>Print Invoice</button>
                        </div>
                    </div>
                    
                    <div class="p-4 flex-grow-1" style="max-height: 400px; overflow-y: auto;">
                        <div class="table-responsive">
                            <table class="table table-dark table-borderless align-middle mb-0">
                                <thead class="text-muted small fw-bold">
                                    <tr>
                                        <th>ITEM</th>
                                        <th class="text-center">QTY</th>
                                        <th class="text-end">PRICE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="rounded-3 bg-glass" style="width: 45px; height: 45px; overflow: hidden;">
                                                    <img src="{{ $item->product->display_image }}" class="w-100 h-100 object-fit-cover">
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 fw-bold small text-white">{{ $item->product->name }}</h6>
                                                    <small class="text-muted" style="font-size: 0.65rem;">Gourmet Choice</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center fw-bold small">x{{ $item->quantity }}</td>
                                        <td class="text-end fw-bold text-orange">PKR {{ number_format($item->price * $item->quantity, 0) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="p-4 bg-glass border-top border-glass">
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="p-3 rounded-4 bg-dark bg-opacity-50 border border-glass h-100">
                                    <small class="text-muted d-block mb-1">DELIVERING TO</small>
                                    <p class="mb-0 fw-bold small text-white">{{ $order->address }}</p>
                                    <small class="text-orange fw-bold" style="font-size: 0.65rem;">Home Office</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-4 rounded-4 bg-orange bg-opacity-10 border border-orange border-opacity-25">
                                    <div class="d-flex justify-content-between mb-2 small">
                                        <span class="text-muted">Subtotal</span>
                                        <span class="fw-bold">PKR {{ number_format($order->total - 500, 0) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2 small">
                                        <span class="text-muted">Service Fee</span>
                                        <span class="text-success fw-bold">PKR 500</span>
                                    </div>
                                    <hr class="border-glass my-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fw-bold text-white">Grand Total</span>
                                        <span class="h5 mb-0 fw-bold text-orange">PKR {{ number_format($order->total, 0) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .tracking-timeline {
        position: relative;
        padding-left: 50px;
    }
    .tracking-timeline::before {
        content: '';
        position: absolute;
        left: 22px;
        top: 0;
        bottom: 0;
        width: 3px;
        background: linear-gradient(to bottom, var(--accent-orange), var(--glass-border));
        border-radius: 10px;
    }
    .timeline-item {
        position: relative;
        padding-bottom: 40px;
        opacity: 0.3;
        transition: var(--transition-smooth);
    }
    .live-dot-pulse {
        width: 8px;
        height: 8px;
        background-color: var(--accent-orange);
        border-radius: 50%;
        animation: pulse-orange 1.5s infinite;
    }
    @keyframes pulse-orange {
        0% { box-shadow: 0 0 0 0 rgba(255, 92, 0, 0.7); }
        70% { box-shadow: 0 0 0 6px rgba(255, 92, 0, 0); }
        100% { box-shadow: 0 0 0 0 rgba(255, 92, 0, 0); }
    }
    .timeline-item.completed { opacity: 0.8; }
    .timeline-item.active { 
        opacity: 1; 
        transform: scale(1.05) translateX(10px); 
    }
    
    .timeline-icon {
        position: absolute;
        left: -48px;
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: #1A1A1B;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        z-index: 2;
        border: 2px solid var(--glass-border);
        transition: var(--transition-smooth);
    }
    .timeline-item.completed .timeline-icon, 
    .timeline-item.active .timeline-icon {
        background: var(--accent-orange);
        border-color: var(--accent-orange);
        box-shadow: 0 0 20px var(--accent-glow);
    }
    .timeline-item.active h6 { color: var(--accent-orange); font-size: 1.1rem; }

    @media print {
        .navbar, .mobile-bottom-nav, .qr-scanner-btn, .col-lg-5, .btn-glass, .bg-orange-light {
            display: none !important;
        }
        .col-lg-7 { width: 100% !important; }
        body { background: white !important; color: black !important; }
        .glass-card { background: white !important; border: 1px solid #ddd !important; color: black !important; }
        .text-orange { color: #FF5C00 !important; }
        .table { color: black !important; }
    }
</style>
<script>
    // Live Order Status Tracking Refresher
    function refreshOrderStatus() {
        fetch(window.location.href)
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                
                // Update Timeline
                const newTimeline = doc.querySelector('.tracking-timeline');
                const oldTimeline = document.querySelector('.tracking-timeline');
                if (newTimeline && oldTimeline && newTimeline.innerHTML !== oldTimeline.innerHTML) {
                    oldTimeline.style.opacity = '0';
                    setTimeout(() => {
                        oldTimeline.innerHTML = newTimeline.innerHTML;
                        oldTimeline.style.opacity = '1';
                    }, 300);
                }
            })
            .catch(err => console.warn('Error refreshing status:', err));
    }
    
    // Refresh every 5 seconds
    setInterval(refreshOrderStatus, 5000);
</script>
@endsection
