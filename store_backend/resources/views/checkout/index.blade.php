@extends('layouts.app')

@section('title', 'Checkout - FoodDash Premium')

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    .form-control-glass, .form-select-glass {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid var(--glass-border);
        color: white;
        padding: 14px 20px;
        border-radius: 12px;
        transition: var(--transition-smooth);
    }
    .form-control-glass::placeholder, .form-select-glass::placeholder {
        color: rgba(255, 255, 255, 0.4) !important;
    }
    .form-control-glass:focus {
        background: rgba(255, 255, 255, 0.07);
        border-color: var(--accent-orange);
        box-shadow: 0 0 15px var(--accent-glow);
        color: white;
    }
    .map-mock {
        height: 200px;
        background: #1A1A1B;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
        border: 1px solid var(--glass-border);
    }
    .map-dot {
        width: 15px;
        height: 15px;
        background: var(--accent-orange);
        border-radius: 50%;
        box-shadow: 0 0 20px var(--accent-orange);
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.5); opacity: 0.5; }
        100% { transform: scale(1); opacity: 1; }
    }
    .payment-card input:checked + .glass-card {
        border-color: var(--accent-orange) !important;
        opacity: 1 !important;
        box-shadow: 0 0 15px rgba(255, 122, 0, 0.2);
    }
    .payment-card input:not(:checked) + .glass-card {
        border-color: var(--glass-border) !important;
        opacity: 0.5 !important;
        box-shadow: none;
    }
    .btn-checkout-premium {
        background: linear-gradient(45deg, #FF7A00, #FF4500);
        border: none;
        border-radius: 12px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    .btn-checkout-premium:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 25px rgba(255, 122, 0, 0.4) !important;
        background: linear-gradient(45deg, #FF8C00, #FF5500);
    }
    .btn-checkout-premium::after {
        content: '';
        position: absolute;
        top: -50%; left: -50%;
        width: 200%; height: 200%;
        background: rgba(255,255,255,0.1);
        transform: rotate(45deg);
        animation: premiumShine 3s infinite;
    }
    @keyframes premiumShine {
        0% { transform: translateX(-100%) rotate(45deg); }
        100% { transform: translateX(100%) rotate(45deg); }
    }
</style>
@endsection

@section('content')
<div class="container py-5">
    <div class="row g-5">
        <!-- Checkout Form -->
        <div class="col-lg-7">
            <h2 class="mb-5 display-6 fw-bold">Finish Your <span class="text-orange">Order</span></h2>
            
            <form action="{{ route('checkout.store') }}" method="POST">
                @csrf
                <div class="glass-card p-4 mb-4">
                    <h4 class="mb-4 d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-orange-light p-2" style="background: rgba(255, 92, 0, 0.1);">
                            <i class="fa-solid fa-location-dot text-orange"></i>
                        </div>
                        Delivery Location
                    </h4>
                    
                    <!-- Interactive Leaflet Map -->
                    <div id="checkoutMap" class="mb-4 rounded-4 overflow-hidden border border-glass shadow-lg" style="height: 250px; z-index: 1;"></div>
                    <input type="hidden" name="latitude" id="latInput" value="33.6844">
                    <input type="hidden" name="longitude" id="lngInput" value="73.0479">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-white-50 small fw-bold">FIRST NAME</label>
                            <input type="text" name="first_name" class="form-control form-control-glass" placeholder="e.g. Ahmed" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-white-50 small fw-bold">LAST NAME</label>
                            <input type="text" name="last_name" class="form-control form-control-glass" placeholder="e.g. Khan" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label text-white-50 small fw-bold">EMAIL ADDRESS</label>
                            <input type="email" name="email" class="form-control form-control-glass" placeholder="e.g. ahmed.khan@example.com" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label text-white-50 small fw-bold">DELIVERY ADDRESS</label>
                            <div class="input-group">
                                <span class="input-group-text bg-glass border-glass text-orange"><i class="fa-solid fa-house"></i></span>
                                <input type="text" name="address" class="form-control form-control-glass" placeholder="e.g. Street 10, Sector F-8, House #42" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-white-50 small fw-bold">CITY</label>
                            <input type="text" name="city" class="form-control form-control-glass" placeholder="e.g. Islamabad" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-white-50 small fw-bold">PHONE NUMBER</label>
                            <input type="text" name="phone" class="form-control form-control-glass" placeholder="e.g. +92 300 1234567" required>
                        </div>
                    </div>

                    <h4 class="mb-4 mt-5 d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-orange-light p-2" style="background: rgba(255, 92, 0, 0.1);">
                            <i class="fa-solid fa-credit-card text-orange"></i>
                        </div>
                        Payment Choice
                    </h4>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="payment-card w-100">
                                <input type="radio" name="payment_method" value="cod" class="d-none" id="paymentCod" checked>
                                <div class="glass-card p-3 text-center cursor-pointer border-2 transition-all">
                                    <i class="fa-solid fa-hand-holding-dollar fs-3 mb-2 text-orange"></i>
                                    <span class="d-block fw-bold small">Cash on Delivery</span>
                                </div>
                            </label>
                        </div>
                        <div class="col-md-6">
                            <label class="payment-card w-100">
                                <input type="radio" name="payment_method" value="card" class="d-none" id="paymentCard">
                                <div class="glass-card p-3 text-center cursor-pointer border-2 transition-all">
                                    <i class="fa-solid fa-credit-card fs-3 mb-2 text-orange"></i>
                                    <span class="d-block fw-bold small">Digital Payment</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Hidden Credit Card Form -->
                    <div id="creditCardForm" class="mt-4 p-4 glass-card rounded-4 border-orange d-none" style="background: rgba(255, 122, 0, 0.05);">
                        <h6 class="text-orange mb-3 fw-bold"><i class="fa-solid fa-lock me-2"></i>Secure Card Details</h6>
                        <div class="mb-3">
                            <input type="text" class="form-control form-control-glass" placeholder="Card Number (e.g. 4111 1111 1111 1111)">
                        </div>
                        <div class="row g-3">
                            <div class="col-6">
                                <input type="text" class="form-control form-control-glass" placeholder="MM/YY">
                            </div>
                            <div class="col-6">
                                <input type="password" class="form-control form-control-glass" placeholder="CVC">
                            </div>
                        </div>
                        <small class="text-white-50 mt-3 d-block"><i class="fa-solid fa-shield-check me-1 text-success"></i> 256-bit AES Encryption Active</small>
                    </div>
                </div>
                
                <button type="submit" class="btn-checkout-premium w-100 py-3 mt-4 text-white fw-bold fs-5 shadow-lg d-flex align-items-center justify-content-center gap-2">
                    <i class="fa-solid fa-bolt text-warning"></i> Confirm & Place Order <i class="fa-solid fa-arrow-right ms-1"></i>
                </button>
            </form>
        </div>

        <!-- Order Summary -->
        <div class="col-lg-5">
            <div class="glass-card p-4 sticky-top" style="top: 100px;">
                <h4 class="mb-4 fw-bold">Bag <span class="text-orange">Summary</span></h4>
                
                <div class="checkout-items mb-4 pe-2" style="max-height: 350px; overflow-y: auto;">
                    @foreach($cartItems as $item)
                        <div class="d-flex align-items-center mb-3">
                            <div class="position-relative me-3">
                                <img src="{{ $item['product']->display_image }}" 
                                     style="width: 65px; height: 65px; object-fit: cover; border-radius: 15px;" class="border border-glass">
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-orange" style="font-size: 0.6rem;">{{ $item['quantity'] }}</span>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-0 fw-bold small text-white">{{ $item['product']->name }}</h6>
                                <small class="text-white-50 d-block" style="font-size: 0.7rem;">Gourmet Selection</small>
                            </div>
                            <span class="fw-bold text-orange">PKR {{ number_format($item['total'], 0) }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="price-breakdown border-top border-glass pt-4">
                    <div class="d-flex justify-content-between mb-2 small">
                        <span class="text-white-50">Subtotal</span>
                        <span class="fw-bold">PKR {{ number_format($subtotal, 0) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2 small">
                        <span class="text-white-50">Platform Fee</span>
                        <span class="text-success fw-bold">PKR 500</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2 small">
                        <span class="text-white-50">Delivery</span>
                        <span class="text-orange fw-bold">FREE</span>
                    </div>
                    <hr class="border-glass">
                    <div class="d-flex justify-content-between mb-4">
                        <span class="h5 fw-bold mb-0">Total</span>
                        <span class="h4 fw-bold text-orange mb-0">PKR {{ number_format($subtotal + 500, 0) }}</span>
                    </div>
                </div>
                
                <div class="bg-glass p-3 rounded-4 border border-glass">
                    <div class="d-flex align-items-center gap-3">
                        <i class="fa-solid fa-shield-check text-success fs-4"></i>
                        <div>
                            <p class="mb-0 fw-bold small">Secure Transaction</p>
                            <p class="mb-0 text-muted" style="font-size: 0.65rem;">End-to-end encrypted payment</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var map = L.map('checkoutMap').setView([33.6844, 73.0479], 13);
        
        L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; CARTO'
        }).addTo(map);

        var markerIcon = L.divIcon({
            className: 'custom-div-icon',
            html: '<div style="background-color:#FF7A00; width:20px; height:20px; border-radius:50%; border:3px solid white; box-shadow: 0 0 15px #FF7A00;"></div>',
            iconSize: [20, 20],
            iconAnchor: [10, 10]
        });

        var marker = L.marker([33.6844, 73.0479], {icon: markerIcon, draggable: true}).addTo(map);

        marker.on('dragend', function(e) {
            var position = marker.getLatLng();
            document.getElementById('latInput').value = position.lat;
            document.getElementById('lngInput').value = position.lng;
        });
        
        map.on('click', function(e) {
            marker.setLatLng(e.latlng);
            document.getElementById('latInput').value = e.latlng.lat;
            document.getElementById('lngInput').value = e.latlng.lng;
        });

        // Toggle Credit Card Form
        const paymentCod = document.getElementById('paymentCod');
        const paymentCard = document.getElementById('paymentCard');
        const ccForm = document.getElementById('creditCardForm');

        function toggleCCForm() {
            if (paymentCard.checked) {
                ccForm.classList.remove('d-none');
                ccForm.classList.add('animate__animated', 'animate__fadeInDown', 'animate__faster');
            } else {
                ccForm.classList.add('d-none');
            }
        }

        paymentCod.addEventListener('change', toggleCCForm);
        paymentCard.addEventListener('change', toggleCCForm);
    });
</script>
@endsection
