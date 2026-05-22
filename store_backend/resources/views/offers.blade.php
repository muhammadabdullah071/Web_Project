@extends('layouts.app')

@section('title', 'Special Offers - FoodDash Premium')

@section('styles')
<style>
    .vip-card-premium {
        background: rgba(18, 18, 24, 0.45);
        border: 1px solid rgba(255, 122, 0, 0.18);
        border-radius: 36px;
        padding: 60px 40px;
        position: relative;
        overflow: hidden;
        backdrop-filter: blur(30px);
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.75), inset 0 1px 0 rgba(255, 255, 255, 0.05);
        z-index: 1;
    }
    .vip-glow-orb {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 350px;
        height: 350px;
        background: radial-gradient(circle, rgba(255, 122, 0, 0.15) 0%, transparent 70%);
        filter: blur(60px);
        z-index: 0;
        pointer-events: none;
    }
    .float-plane-box {
        animation: float-plane 3s infinite ease-in-out;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 122, 0, 0.08);
        border: 1px solid rgba(255, 122, 0, 0.3);
        box-shadow: 0 0 35px rgba(255, 122, 0, 0.25);
        border-radius: 50%;
        width: 76px;
        height: 76px;
    }
    @keyframes float-plane {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        50% { transform: translateY(-8px) rotate(6deg); }
    }
    .vip-badge {
        background: rgba(255, 159, 0, 0.1);
        border: 1px solid rgba(255, 159, 0, 0.25);
        color: #FF9F00;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 2px;
        padding: 6px 16px;
        border-radius: 30px;
        display: inline-flex;
        align-items: center;
        margin-bottom: 24px;
        text-shadow: 0 0 10px rgba(255, 159, 0, 0.3);
    }
    .vip-subscribe-capsule {
        background: rgba(10, 10, 12, 0.8);
        border: 1px solid rgba(255, 122, 0, 0.15);
        border-radius: 50px;
        padding: 5px 5px 5px 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        max-width: 520px;
        margin: 0 auto;
        backdrop-filter: blur(15px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4), inset 0 1px 1px rgba(255, 255, 255, 0.05);
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    }
    .vip-subscribe-capsule:focus-within {
        border-color: #FF7A00;
        box-shadow: 0 0 25px rgba(255, 122, 0, 0.35), 0 15px 35px rgba(0, 0, 0, 0.4);
        background: rgba(10, 10, 12, 0.95);
    }
    .vip-subscribe-capsule input {
        background: transparent;
        border: none;
        color: white;
        width: 100%;
        outline: none;
        font-size: 0.95rem;
    }
    .vip-subscribe-capsule input::placeholder {
        color: rgba(255, 255, 255, 0.45);
    }
    .vip-sub-btn {
        background: linear-gradient(135deg, #FF9F00 0%, #FF7A00 100%);
        border: none;
        color: white;
        font-weight: 700;
        font-size: 0.88rem;
        padding: 14px 28px;
        border-radius: 40px;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(255, 122, 0, 0.35);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
    }
    .vip-sub-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(255, 122, 0, 0.5);
    }
</style>
@endsection

@section('content')
<div class="container py-5 mt-5">
    <div class="text-center mb-5 animate__animated animate__fadeInDown">
        <h1 class="display-4 font-poppins text-white fw-bold mb-3"><i class="fa-solid fa-tags text-orange me-3"></i>Special Offers</h1>
        <p class="text-secondary fs-5 max-w-md mx-auto">Discover exclusive deals, discounts, and premium bundles from our top-rated partner restaurants.</p>
    </div>

    <div class="row g-4 mb-5">
        <!-- Offer 1 -->
        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
            <div class="glass-card h-100 position-relative overflow-hidden" style="border: 1px solid rgba(255,122,0,0.3);">
                <div class="position-absolute top-0 end-0 bg-orange text-white px-3 py-1 rounded-bl-3 fw-bold" style="background-color: var(--accent-orange); border-bottom-left-radius: 15px;">30% OFF</div>
                <div style="height: 200px; overflow: hidden; border-radius: 15px 15px 0 0;">
                    <img src="https://images.unsplash.com/photo-1568901346375-23c9450c58cd?q=80&w=800" class="w-100 h-100 object-fit-cover" alt="Burger Combo" style="transition: transform 0.5s;">
                </div>
                <div class="p-4">
                    <h4 class="font-poppins text-white mb-2">Weekend Burger Fest</h4>
                    <p class="text-secondary small mb-3">Get 30% off on all signature smashed burgers at Burger Lab. Valid this weekend only!</p>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <span class="badge bg-dark border border-secondary text-orange px-3 py-2">Code: BURGER30</span>
                        <a href="{{ route('restaurants.index') }}" class="btn btn-sm btn-premium rounded-pill px-3">Claim Offer</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Offer 2 -->
        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
            <div class="glass-card h-100 position-relative overflow-hidden">
                <div class="position-absolute top-0 end-0 text-white px-3 py-1 rounded-bl-3 fw-bold" style="background-color: #10B981; border-bottom-left-radius: 15px;">FREE DELIVERY</div>
                <div style="height: 200px; overflow: hidden; border-radius: 15px 15px 0 0;">
                    <img src="https://images.unsplash.com/photo-1604068549290-dea0e4a305ca?q=80&w=800" class="w-100 h-100 object-fit-cover" alt="Pizza" style="transition: transform 0.5s;">
                </div>
                <div class="p-4">
                    <h4 class="font-poppins text-white mb-2">Midnight Pizza Party</h4>
                    <p class="text-secondary small mb-3">Free delivery on all orders above PKR 2000 from Pizza Hut Elite. Perfect for late night cravings.</p>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <span class="badge bg-dark border border-secondary text-success px-3 py-2">Auto Applied</span>
                        <a href="{{ route('restaurants.index') }}" class="btn btn-sm btn-glass-outline rounded-pill px-3">Order Now</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Offer 3 -->
        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
            <div class="glass-card h-100 position-relative overflow-hidden">
                <div class="position-absolute top-0 end-0 bg-primary text-white px-3 py-1 rounded-bl-3 fw-bold" style="border-bottom-left-radius: 15px;">BUY 1 GET 1</div>
                <div style="height: 200px; overflow: hidden; border-radius: 15px 15px 0 0;">
                    <img src="https://images.unsplash.com/photo-1551024506-0bccd828d307?q=80&w=800" class="w-100 h-100 object-fit-cover" alt="Dessert" style="transition: transform 0.5s;">
                </div>
                <div class="p-4">
                    <h4 class="font-poppins text-white mb-2">Sweet Tooth Tuesday</h4>
                    <p class="text-secondary small mb-3">Buy any Belgian Waffle and get a Royal Saffron Kulfi absolutely free at The Sweet Spot.</p>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <span class="badge bg-dark border border-secondary text-primary px-3 py-2">Code: SWEETBOGO</span>
                        <a href="{{ route('restaurants.index') }}" class="btn btn-sm btn-glass-outline rounded-pill px-3">Claim Offer</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="vip-card-premium mt-5 mb-5 text-center position-relative" data-aos="zoom-in">
        <div class="vip-glow-orb"></div>
        <div class="position-relative z-1">
            <span class="vip-badge">
                <i class="fa-solid fa-gem text-warning me-2 animate-pulse"></i> VIP CLUB BENEFIT
            </span>
            
            <div class="d-block mb-4">
                <div class="float-plane-box">
                    <i class="fa-solid fa-paper-plane text-orange fs-3 animate__animated animate__bounce"></i>
                </div>
            </div>
            
            <h2 class="font-poppins text-white fw-bold mb-3 display-6">Get Exclusive <span class="text-gradient-orange">VIP Deals</span></h2>
            <p class="text-white-50 fs-6 mb-5 mx-auto" style="max-width: 520px; line-height: 1.7;">Join 10,000+ foodies receiving secret promo codes, early access to new restaurant launches, and weekly premium bundles.</p>
            
            <form class="vip-subscribe-capsule" onsubmit="event.preventDefault(); document.getElementById('subBtn').innerHTML = 'Successfully Joined <i class=\'fa-solid fa-check-double ms-2\'></i>'; document.getElementById('subBtn').classList.replace('vip-sub-btn', 'btn-success'); this.reset();">
                <i class="fa-regular fa-envelope text-orange fs-5 ms-2"></i>
                <input type="email" placeholder="Enter your email address..." required>
                <button class="vip-sub-btn" type="submit" id="subBtn">
                    Subscribe Now <i class="fa-solid fa-arrow-right"></i>
                </button>
            </form>
            
            <div class="mt-4 text-white-50 small d-flex align-items-center justify-content-center gap-2">
                <i class="fa-solid fa-shield-halved text-success"></i> No spam, only delicious updates. Unsubscribe anytime.
            </div>
        </div>
    </div>
</div>
@endsection
