@extends('layouts.app')

@section('title', 'FoodDash | Premium Food Delivery')

@section('styles')
<style>
    /* Hero Section */
    .hero-section {
        min-height: 100vh;
        position: relative;
        display: flex;
        align-items: center;
        padding-top: 80px;
        overflow: hidden;
    }
    
    .hero-bg {
        position: absolute;
        inset: 0;
        z-index: -2;
        background: url('https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=2070') center/cover no-repeat;
    }

    .hero-overlay {
        position: absolute;
        inset: 0;
        z-index: -1;
        background: linear-gradient(90deg, var(--bg-dark-1) 0%, rgba(15,15,15,0.85) 50%, rgba(15,15,15,0.4) 100%);
    }

    .hero-title {
        font-size: 4.5rem;
        line-height: 1.1;
        letter-spacing: -2px;
        margin-bottom: 1.5rem;
    }

    /* Floating UI Widget */
    .hero-widget {
        position: absolute;
        right: 10%;
        top: 30%;
        background: rgba(255,255,255,0.08);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255,255,255,0.15);
        border-radius: 24px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        box-shadow: 0 30px 60px rgba(0,0,0,0.6), 0 0 40px rgba(255,122,0,0.2);
        z-index: 5;
    }

    /* Search Bar Premium Overhaul */
    .premium-search {
        background: rgba(15, 15, 20, 0.7);
        border: 1px solid rgba(255, 122, 0, 0.2);
        border-radius: 40px;
        padding: 5px 5px 5px 20px;
        display: flex;
        align-items: center;
        gap: 12px;
        max-width: 410px; /* Incredibly compact, much shorter! */
        backdrop-filter: blur(30px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.6), inset 0 1px 1px rgba(255, 255, 255, 0.05);
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        position: relative;
        z-index: 10;
    }
    .premium-search:focus-within {
        border-color: #FF7A00;
        box-shadow: 0 0 30px rgba(255, 122, 0, 0.4), 0 20px 40px rgba(0, 0, 0, 0.6);
        background: rgba(15, 15, 20, 0.88);
    }
    .premium-search input {
        background: transparent;
        border: none;
        color: white;
        width: 100%;
        outline: none;
        font-size: 0.95rem; /* Sleeker, smaller text size */
        transition: transform 0.25s ease;
    }
    .premium-search input::placeholder {
        color: rgba(255,255,255,0.45);
    }
    
    .location-pin-pulse {
        animation: pin-glow 2s infinite ease-in-out;
    }
    @keyframes pin-glow {
        0%, 100% { opacity: 0.6; transform: scale(1); filter: drop-shadow(0 0 2px rgba(255, 122, 0, 0.3)); }
        50% { opacity: 1; transform: scale(1.1); filter: drop-shadow(0 0 8px rgba(255, 122, 0, 0.8)); }
    }
    
    .find-food-btn-circle {
        background: linear-gradient(135deg, #FF9F00 0%, #FF7A00 100%);
        border: none;
        color: white;
        width: 42px;
        height: 42px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        cursor: pointer;
        box-shadow: 0 4px 15px rgba(255, 122, 0, 0.35);
        transition: all 0.35s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    .find-food-btn-circle:hover {
        transform: scale(1.08) rotate(90deg); /* Modern premium arrow rotate! */
        box-shadow: 0 0 20px rgba(255, 122, 0, 0.6);
    }
    
    /* Location Suggestion Dropdown Panel */
    /* Sleek Horizontal Location Pills Styling */
    .location-suggestions-container {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        margin-top: 10px;
    }
    .suggestions-label {
        font-size: 0.85rem;
        font-weight: 700;
        color: rgba(255,255,255,0.45);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .suggestions-row {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }
    .suggestion-pill {
        display: inline-flex;
        align-items: center;
        padding: 6px 14px;
        border-radius: 20px;
        background: rgba(255, 122, 0, 0.06);
        border: 1px solid rgba(255, 122, 0, 0.15);
        color: rgba(255, 255, 255, 0.85);
        font-size: 0.85rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.25s cubic-bezier(0.165, 0.84, 0.44, 1);
    }
    .suggestion-pill:hover {
        background: #FF7A00;
        border-color: #FF7A00;
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(255, 122, 0, 0.4);
    }
    
    /* Overlapping Portraits & Sparkly Stars */
    .bg-gradient-orange {
        background: linear-gradient(135deg, #FF9F00 0%, #FF7A00 100%);
    }
    .avatar-portrait {
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        object-fit: cover;
        box-shadow: 0 8px 16px rgba(0,0,0,0.5);
    }
    .avatar-portrait:hover {
        transform: translateY(-8px) scale(1.2) rotate(4deg);
        z-index: 10 !important;
        border-color: #FF7A00 !important;
        box-shadow: 0 0 20px rgba(255, 122, 0, 0.6);
    }
    .testimonial-avatars {
        display: flex;
        align-items: center;
    }
    .star-pulse {
        animation: star-glow 3s infinite ease-in-out;
    }
    .star-pulse:nth-child(2) { animation-delay: 0.2s; }
    .star-pulse:nth-child(3) { animation-delay: 0.4s; }
    .star-pulse:nth-child(4) { animation-delay: 0.6s; }
    .star-pulse:nth-child(5) { animation-delay: 0.8s; }
    @keyframes star-glow {
        0%, 100% { transform: scale(1); filter: drop-shadow(0 0 0px transparent); }
        50% { transform: scale(1.25); color: #FFB300; filter: drop-shadow(0 0 8px rgba(255, 179, 0, 0.9)); }
    }

    /* Category Cards */
    .cat-card {
        aspect-ratio: 1;
        border-radius: 30px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        cursor: pointer;
        background: linear-gradient(180deg, rgba(255,255,255,0.05) 0%, rgba(255,255,255,0.01) 100%);
        border: 1px solid rgba(255,255,255,0.05);
        transition: var(--transition-smooth);
    }
    .cat-card img {
        width: 80px; height: 80px;
        object-fit: contain;
        margin-bottom: 15px;
        transition: var(--transition-bounce);
        filter: drop-shadow(0 10px 10px rgba(0,0,0,0.5));
    }
    .cat-card:hover {
        background: rgba(255,122,0,0.1);
        border-color: rgba(255,122,0,0.3);
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(255,122,0,0.15);
    }
    .cat-card:hover img {
        transform: scale(1.15) translateY(-5px);
    }

    /* Live Tracking Simulation */
    .tracking-card {
        background: #1A1A1A;
        border-radius: 30px;
        padding: 30px;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(255,255,255,0.05);
    }
    .map-bg {
        position: absolute;
        inset: 0;
        opacity: 0.2;
        background: url('https://images.unsplash.com/photo-1524661135-423995f22d0b?q=80&w=2074') center/cover;
        z-index: 0;
        filter: grayscale(100%) invert(100%);
    }
    .tracking-content {
        position: relative;
        z-index: 1;
    }
    .pulse-dot {
        width: 12px; height: 12px;
        background: #00E676;
        border-radius: 50%;
        box-shadow: 0 0 0 0 rgba(0, 230, 118, 0.7);
        animation: pulse-green 1.5s infinite;
    }
    @keyframes pulse-green {
        0% { box-shadow: 0 0 0 0 rgba(0, 230, 118, 0.7); }
        70% { box-shadow: 0 0 0 15px rgba(0, 230, 118, 0); }
        100% { box-shadow: 0 0 0 0 rgba(0, 230, 118, 0); }
    }

    /* Deal Banners */
    .deal-banner {
        border-radius: 24px;
        overflow: hidden;
        position: relative;
        min-height: 220px;
        display: flex;
        align-items: center;
        padding: 30px;
    }
    .deal-banner::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(90deg, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.2) 100%);
        z-index: 1;
    }
    .deal-content { position: relative; z-index: 2; }

    /* Startup Restaurant Cards */
    .startup-restaurant-card {
        background: rgba(20, 20, 25, 0.45);
        border: 1px solid rgba(255, 255, 255, 0.04);
        border-radius: 24px;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        position: relative;
        cursor: pointer;
    }
    .startup-restaurant-card::after {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: 24px;
        padding: 1px;
        background: linear-gradient(135deg, rgba(255, 122, 0, 0.4), transparent 50%, rgba(255, 255, 255, 0.05));
        -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        -webkit-mask-composite: xor;
        mask-composite: exclude;
        opacity: 0;
        transition: opacity 0.4s ease;
    }
    .startup-restaurant-card:hover {
        transform: translateY(-8px) scale(1.01);
        background: rgba(20, 20, 25, 0.7);
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.7), 0 0 30px rgba(255, 122, 0, 0.15);
    }
    .startup-restaurant-card:hover::after {
        opacity: 1;
    }
    .rc-img-container {
        height: 220px;
        overflow: hidden;
        position: relative;
    }
    .rc-img-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
    }
    .startup-restaurant-card:hover .rc-img-container img {
        transform: scale(1.06);
    }
    .rc-badge-pill {
        background: rgba(12, 12, 16, 0.85);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 30px;
        padding: 6px 14px;
        font-size: 0.78rem;
        font-weight: 600;
        color: #ffffff;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .rc-favorite-btn {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: rgba(12, 12, 16, 0.85);
        border: 1px solid rgba(255, 255, 255, 0.08);
        color: rgba(255,255,255,0.7);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .rc-favorite-btn:hover {
        background: #FF7A00;
        border-color: #FF7A00;
        color: #ffffff;
        transform: scale(1.1);
        box-shadow: 0 0 15px rgba(255, 122, 0, 0.5);
    }
    .startup-card-body {
        padding: 24px;
    }
    .startup-card-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 6px;
        transition: color 0.3s;
    }
    .startup-restaurant-card:hover .startup-card-title {
        color: #FF7A00;
    }
    .startup-tag-row {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 20px;
    }
    .startup-tag {
        font-size: 0.75rem;
        font-weight: 500;
        color: rgba(255, 255, 255, 0.45);
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.06);
        padding: 4px 10px;
        border-radius: 6px;
    }
    .startup-card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid rgba(255, 255, 255, 0.06);
        padding-top: 18px;
    }
    .startup-btn {
        background: rgba(255, 122, 0, 0.08);
        border: 1px solid rgba(255, 122, 0, 0.25);
        color: #FF7A00;
        font-size: 0.82rem;
        font-weight: 600;
        padding: 8px 18px;
        border-radius: 20px;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .startup-btn:hover {
        background: #FF7A00;
        border-color: #FF7A00;
        color: #ffffff;
        box-shadow: 0 6px 20px rgba(255, 122, 0, 0.4);
        transform: translateY(-2px);
    }

    @media (max-width: 991px) {
        .hero-title { font-size: 3rem; }
        .hero-widget { display: none; }
    }
</style>
@endsection

@section('content')

<!-- 1. HERO SECTION -->
<section class="hero-section">
    <div class="hero-bg"></div>
    <div class="hero-overlay"></div>
    
    <div class="container position-relative">
        <div class="row align-items-center">
            <div class="col-lg-7" data-aos="fade-up" data-aos-duration="1000">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill mb-4" style="background: rgba(255,122,0,0.1); border: 1px solid rgba(255,122,0,0.2);">
                    <i class="fa-solid fa-motorcycle text-orange"></i>
                    <span class="text-orange fw-bold small text-uppercase tracking-wider">Lightning Fast Delivery</span>
                </div>
                
                <h1 class="hero-title text-white font-poppins">
                    The Premium <br>
                    <span class="text-gradient-orange">Food Experience</span><br>
                    At Your Door.
                </h1>
                
                <p class="fs-5 text-secondary mb-5" style="max-width: 500px;">
                    Order from top-tier restaurants and exclusive chefs. 
                    Track your meal in real-time with our futuristic delivery network.
                </p>
                
                <form action="{{ route('restaurants.index') }}" method="GET" class="premium-search mb-3">
                    <i class="fa-solid fa-location-dot text-orange fs-5 location-pin-pulse"></i>
                    <input type="text" name="location" id="location-input" placeholder="Search in Islamabad..." value="{{ session('user_city', 'Islamabad') }}" autocomplete="off">
                    <button type="submit" class="find-food-btn-circle" style="padding: 0; min-width: 42px;">
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </form>

                <!-- Sleek, Compact Horizontal Location Suggestion Pills -->
                <div class="location-suggestions-container mb-5">
                    <span class="suggestions-label"><i class="fa-solid fa-fire text-orange"></i> Popular:</span>
                    <div class="suggestions-row">
                        <span class="suggestion-pill" data-val="F-7 Markaz, Islamabad">F-7 Markaz</span>
                        <span class="suggestion-pill" data-val="Blue Area, Islamabad">Blue Area</span>
                        <span class="suggestion-pill" data-val="G-11 Markaz, Islamabad">G-11 Markaz</span>
                        <span class="suggestion-pill" data-val="E-11 Sector, Islamabad">E-11 Sector</span>
                        <span class="suggestion-pill" data-val="Centaurus Mall, Islamabad">Centaurus</span>
                        <span class="suggestion-pill" data-val="Bahria Town, Islamabad">Bahria Town</span>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-4">
                    <div class="d-flex -space-x-3 testimonial-avatars">
                        <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=150&h=150&q=80" class="avatar-portrait rounded-circle border border-2 border-dark" width="48" height="48" style="margin-left: -15px; position:relative; z-index: 3;" title="Ayesha">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=150&h=150&q=80" class="avatar-portrait rounded-circle border border-2 border-dark" width="48" height="48" style="margin-left: -15px; position:relative; z-index: 2;" title="Zain">
                        <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=150&h=150&q=80" class="avatar-portrait rounded-circle border border-2 border-dark" width="48" height="48" style="margin-left: -15px; position:relative; z-index: 1;" title="Amara">
                        <div class="avatar-portrait rounded-circle border border-2 border-dark bg-gradient-orange d-flex align-items-center justify-content-center text-white small fw-bold" style="width:48px; height:48px; margin-left:-15px; position:relative; z-index:0; box-shadow: 0 0 15px rgba(255,122,0,0.3);">+2k</div>
                    </div>
                    <div>
                        <div class="d-flex text-warning fs-6 rating-stars">
                            <i class="fa-solid fa-star star-pulse"></i>
                            <i class="fa-solid fa-star star-pulse"></i>
                            <i class="fa-solid fa-star star-pulse"></i>
                            <i class="fa-solid fa-star star-pulse"></i>
                            <i class="fa-solid fa-star star-pulse"></i>
                        </div>
                        <div class="small mt-1" style="color: rgba(255,255,255,0.45);"><strong class="text-white">4.9/5</strong> from 2,000+ reviews</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Floating UI Widgets (Desktop only) -->
    <div class="hero-widget animate-float">
        <img src="https://images.unsplash.com/photo-1568901346375-23c9450c58cd?q=80&w=200&h=200" class="rounded-circle" width="60" height="60" style="object-fit:cover;">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge bg-success rounded-pill px-2 py-1" style="font-size:0.6rem;">On the way</span>
                <span class="text-white fw-bold small">15 min</span>
            </div>
            <div class="text-muted" style="font-size:0.8rem;">Double Cheese Burger</div>
        </div>
    </div>
</section>

<!-- 2. FOOD CATEGORIES -->
<section class="py-5 mt-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-5">
            <div data-aos="fade-right">
                <h6 class="text-orange text-uppercase fw-bold tracking-wider mb-2">What's your mood?</h6>
                <h2 class="font-poppins mb-0">Explore Categories</h2>
            </div>
            <div data-aos="fade-left">
                <div class="d-flex gap-2">
                    <button class="btn btn-glass-outline rounded-circle" style="width:40px; height:40px; padding:0;"><i class="fa-solid fa-chevron-left"></i></button>
                    <button class="btn btn-glass-outline rounded-circle" style="width:40px; height:40px; padding:0;"><i class="fa-solid fa-chevron-right"></i></button>
                </div>
            </div>
        </div>

        <div class="row g-4">
            @php
                $catImages = [
                    'Burger' => 'https://cdn-icons-png.flaticon.com/512/3075/3075977.png',
                    'Pizza' => 'https://cdn-icons-png.flaticon.com/512/3595/3595458.png',
                    'Sushi' => 'https://cdn-icons-png.flaticon.com/512/2254/2254516.png',
                    'BBQ' => 'https://cdn-icons-png.flaticon.com/512/3448/3448011.png',
                    'Desserts' => 'https://cdn-icons-png.flaticon.com/512/3081/3081949.png',
                    'Drinks' => 'https://cdn-icons-png.flaticon.com/512/3050/3050114.png'
                ];
            @endphp
            @foreach(array_slice($catImages, 0, 6) as $name => $img)
            <div class="col-6 col-md-4 col-lg-2" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <a href="{{ route('restaurants.index', ['category' => strtolower($name)]) }}">
                    <div class="cat-card">
                        <img src="{{ $img }}" alt="{{ $name }}">
                        <h6 class="font-poppins text-white m-0">{{ $name }}</h6>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- 3. HOW IT WORKS (Startup Logic) -->
<section class="py-5 bg-dark-deep position-relative overflow-hidden">
    <div class="container py-5">
        <div class="text-center mb-5" data-aos="fade-up">
            <h6 class="text-orange text-uppercase fw-bold tracking-wider mb-2">Our Process</h6>
            <h2 class="font-poppins text-white display-5 mb-3">How FoodDash Works</h2>
            <p class="text-secondary mx-auto" style="max-width: 600px;">Getting your favorite food delivered is now easier than ever. Follow these simple steps for a premium experience.</p>
        </div>

        <div class="row g-4">
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="0">
                <div class="glass-card text-center p-5 h-100 border-glass-hover transition-smooth">
                    <div class="bg-orange bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mx-auto mb-4" style="width: 80px; height: 80px; border: 1px solid var(--accent-orange);">
                        <i class="fa-solid fa-utensils text-orange fs-2"></i>
                    </div>
                    <h4 class="text-white font-poppins mb-3">1. Select Food</h4>
                    <p class="text-secondary mb-0">Browse our curated list of top-rated restaurants and select your favorite dishes.</p>
                </div>
            </div>
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="glass-card text-center p-5 h-100 border-glass-hover transition-smooth">
                    <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mx-auto mb-4" style="width: 80px; height: 80px; border: 1px solid #00E676;">
                        <i class="fa-solid fa-credit-card text-success fs-2"></i>
                    </div>
                    <h4 class="text-white font-poppins mb-3">2. Pay Securely</h4>
                    <p class="text-secondary mb-0">Choose from JazzCash, EasyPaisa, or Cards. Your transaction is 100% encrypted.</p>
                </div>
            </div>
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="glass-card text-center p-5 h-100 border-glass-hover transition-smooth">
                    <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mx-auto mb-4" style="width: 80px; height: 80px; border: 1px solid var(--accent-blue);">
                        <i class="fa-solid fa-truck-fast text-primary fs-2"></i>
                    </div>
                    <h4 class="text-white font-poppins mb-3">3. Rapid Delivery</h4>
                    <p class="text-secondary mb-0">Track your rider in real-time as your meal is delivered fresh to your doorstep.</p>
                </div>
            </div>
        </div>
    </div>
    
    <style>
        .bg-dark-deep { background-color: #0A0A0A; }
        .border-glass-hover:hover {
            border-color: var(--accent-orange) !important;
            box-shadow: 0 20px 50px rgba(0,0,0,0.8), 0 0 30px rgba(255, 122, 0, 0.1) !important;
            transform: translateY(-10px);
        }
    </style>
</section>

<!-- 4. TRENDING DEALS -->
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="deal-banner" style="background: url('https://images.unsplash.com/photo-1555939594-58d7cb561ad1?q=80&w=1000') center/cover;">
                    <div class="deal-content">
                        <span class="badge bg-danger px-3 py-2 rounded-pill mb-3 fw-bold tracking-wider">FLASH DEAL</span>
                        <h2 class="font-poppins text-white mb-2">50% OFF<br>Sushi Platters</h2>
                        <p class="text-secondary mb-4">Code: <strong>SUSHI50</strong></p>
                        <a href="{{ route('restaurants.index') }}" class="btn btn-premium rounded-pill px-4">Order Now</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="deal-banner" style="background: url('https://images.unsplash.com/photo-1586190848861-99aa4a171e90?q=80&w=1000') center/cover;">
                    <div class="deal-content">
                        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill mb-3 fw-bold tracking-wider">NEW ARRIVAL</span>
                        <h2 class="font-poppins text-white mb-2">Free Delivery<br>On Burgers</h2>
                        <p class="text-secondary mb-4">Valid till midnight tonight.</p>
                        <a href="{{ route('restaurants.index') }}" class="btn btn-premium rounded-pill px-4">Claim Offer</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 4. FEATURED RESTAURANTS -->
<section class="py-5 mb-5">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h6 class="text-orange text-uppercase fw-bold tracking-wider mb-2">Top Rated</h6>
            <h2 class="font-poppins mb-0">Featured Restaurants</h2>
        </div>

        <div class="row g-4">
            @forelse($trendingNearYou ?? [] as $restaurant)
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="startup-restaurant-card h-100" onclick="window.location.href='{{ route('restaurants.show', $restaurant->slug) }}'">
                    <div class="rc-img-container">
                        <img src="{{ $restaurant->display_image }}" alt="{{ $restaurant->name }}">
                        <!-- Top floating widgets -->
                        <div class="position-absolute top-0 start-0 w-100 p-3 d-flex justify-content-between z-10" style="z-index: 5;">
                            <span class="rc-badge-pill">
                                <i class="fa-solid fa-bolt text-orange"></i> {{ $restaurant->delivery_time ?? '25' }} min
                            </span>
                            <button class="rc-favorite-btn" onclick="event.stopPropagation(); event.preventDefault(); this.querySelector('i').classList.toggle('fa-regular'); this.querySelector('i').classList.toggle('fa-solid'); this.querySelector('i').classList.toggle('text-danger');">
                                <i class="fa-regular fa-heart"></i>
                            </button>
                        </div>
                    </div>
                    <div class="startup-card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h3 class="startup-card-title text-truncate m-0" style="max-width: 75%;">{{ $restaurant->name }}</h3>
                            <div class="d-flex align-items-center gap-1 text-warning">
                                <i class="fa-solid fa-star"></i>
                                <span class="fw-bold text-white small" style="font-size:0.9rem;">{{ $restaurant->rating ?? '4.8' }}</span>
                            </div>
                        </div>
                        
                        <div class="startup-tag-row">
                            <span class="startup-tag">{{ $restaurant->cuisine_type ?? 'Gourmet Cuisine' }}</span>
                            <span class="startup-tag">Islamabad</span>
                        </div>
                        
                        <div class="startup-card-footer">
                            <span class="text-secondary small d-flex align-items-center gap-1">
                                <i class="fa-solid fa-motorcycle text-orange"></i> Free Delivery
                            </span>
                            <a href="{{ route('restaurants.show', $restaurant->slug) }}" class="startup-btn">
                                View Menu <i class="fa-solid fa-arrow-right arrow-anim"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
                <!-- Fallback / Static Demo content to show UI -->
                @for($i=1; $i<=3; $i++)
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
                    <div class="glass-card h-100 p-0 group">
                        <div class="position-relative img-zoom-hover" style="height: 220px;">
                            <img src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?q=80&w=1000" class="w-100 h-100 object-fit-cover">
                            <div class="position-absolute top-0 start-0 w-100 p-3 d-flex justify-content-between z-10">
                                <span class="badge bg-dark border border-secondary px-3 py-2 rounded-pill shadow-sm d-flex align-items-center gap-1">
                                    <i class="fa-solid fa-clock text-orange"></i> 20-30 min
                                </span>
                            </div>
                        </div>
                        <div class="p-4">
                            <h4 class="font-poppins mb-2">Gourmet Burger House</h4>
                            <p class="text-muted small mb-4">American • Burgers • Fast Food</p>
                            <a href="#" class="btn btn-glass-outline rounded-pill w-100">View Menu</a>
                        </div>
                    </div>
                </div>
                @endfor
            @endforelse
        </div>
    </div>
</section>

<!-- 5. LIVE TRACKING SIMULATION -->
<section class="py-5 position-relative overflow-hidden">
    <div class="container">
        <div class="tracking-card shadow-lg" data-aos="fade-up">
            <div class="map-bg"></div>
            <div class="tracking-content row align-items-center p-md-4">
                <div class="col-lg-5 mb-4 mb-lg-0">
                    <span class="badge bg-success text-dark px-3 py-2 rounded-pill fw-bold mb-3 d-inline-flex align-items-center gap-2">
                        <div class="pulse-dot"></div> <span id="tracking-status">Live Tracking</span>
                    </span>
                    <h2 class="font-poppins text-white display-5 mb-4">Track your order <br>in real-time.</h2>
                    <p class="text-secondary mb-4">Experience our state-of-the-art live map tracking. Watch your rider navigate the streets of Islamabad with pinpoint accuracy.</p>
                    
                    <div class="d-flex flex-column gap-3">
                        <div class="tracking-step active d-flex align-items-center gap-3 p-3 rounded-4 bg-glass border-glass">
                            <div class="bg-dark rounded-circle d-flex align-items-center justify-content-center" style="width:45px; height:45px;">
                                <i class="fa-solid fa-utensils text-orange"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 text-white">Order Prepared</h6>
                                <small class="text-muted">Burger Lab • 12:45 PM</small>
                            </div>
                        </div>
                        <div class="tracking-step active d-flex align-items-center gap-3 p-3 rounded-4 bg-glass border-glass" id="rider-pickup-step">
                            <div class="bg-dark rounded-circle d-flex align-items-center justify-content-center" style="width:45px; height:45px;">
                                <i class="fa-solid fa-motorcycle text-orange"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 text-white">Rider Picked Up</h6>
                                <small class="text-muted">Asif is on his way</small>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-4 mt-2">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fa-solid fa-clock text-orange"></i>
                                <span class="text-white fw-bold" id="live-eta">7 mins</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <i class="fa-solid fa-route text-orange"></i>
                                <span class="text-white fw-bold">1.2 km</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 position-relative">
                    <div class="position-relative overflow-hidden rounded-4xl shadow-float border border-secondary border-opacity-25" style="height: 450px; background: #111;">
                        <!-- Map Layer -->
                        <iframe id="liveMapFrame" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d106234.34110368143!2d72.99042578500206!3d33.69345260193183!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x38dfbfd07891722f%3A0x6059515c3bdb02b6!2sIslamabad%2C%20Islamabad%20Capital%20Territory%2C%20Pakistan!5e0!3m2!1sen!2sus!4v1715858000000!5m2!1sen!2sus" width="100%" height="100%" style="border:0; filter: invert(100%) hue-rotate(180deg) contrast(90%);" allowfullscreen="" loading="lazy"></iframe>
                        
                        <!-- Rider Simulation Overlay -->
                        <div class="position-absolute inset-0 z-10 pointer-events-none d-flex align-items-center justify-content-center">
                            <div id="rider-marker" style="position: absolute; transition: all 1s linear;">
                                <div class="position-relative">
                                    <div class="rider-pulse"></div>
                                    <div class="bg-orange rounded-circle p-2 shadow-lg border border-2 border-white" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fa-solid fa-motorcycle text-white fs-5"></i>
                                    </div>
                                    <div class="rider-label bg-dark text-white px-2 py-1 rounded-pill small fw-bold position-absolute start-50 translate-middle-x mt-2" style="white-space: nowrap; font-size: 0.6rem;">ASIF (RIDER)</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Rider Interaction Card -->
                    <div class="position-absolute glass-panel p-3 d-flex align-items-center gap-3 shadow-lg m-3" style="bottom: 0; left: 0; right: 0; max-width: 350px;">
                        <div class="position-relative">
                            <img src="https://ui-avatars.com/api/?name=Asif&background=FF7A00&color=fff" class="rounded-circle border border-2 border-orange" width="55" height="55">
                            <div class="position-absolute bottom-0 end-0 bg-success rounded-circle border border-2 border-dark" style="width:14px; height:14px;"></div>
                        </div>
                        <div class="text-start flex-grow-1">
                            <h6 class="mb-0 text-white font-poppins fw-bold">Asif Mehmood</h6>
                            <div class="d-flex align-items-center gap-1 text-warning" style="font-size: 0.7rem;">
                                <i class="fa-solid fa-star"></i> 4.9 • <span class="text-secondary">250+ Orders</span>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-glass-outline rounded-circle" style="width:40px; height:40px; padding:0; border-color: rgba(255,255,255,0.1);"><i class="fa-solid fa-message text-white"></i></button>
                            <button onclick="callRider()" class="btn btn-premium rounded-circle" style="width:40px; height:40px; padding:0;"><i class="fa-solid fa-phone"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function callRider() {
        const btn = event.currentTarget;
        const originalContent = btn.innerHTML;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>';
        setTimeout(() => {
            btn.innerHTML = originalContent;
            alert('Connecting to Rider Asif... Please stay on the line.');
        }, 1000);
    }

    // Dynamic Rider Movement Simulation
    document.addEventListener('DOMContentLoaded', function() {
        const marker = document.getElementById('rider-marker');
        const etaText = document.getElementById('live-eta');
        const statusBadge = document.getElementById('tracking-status');
        
        let progress = 0;
        const path = [
            { x: -100, y: -50 },
            { x: -50, y: -20 },
            { x: 20, y: 30 },
            { x: 80, y: 10 },
            { x: 0, y: 0 }
        ];

        function updateRider() {
            progress = (progress + 1) % 100;
            const index = Math.floor((progress / 100) * (path.length - 1));
            const nextIndex = (index + 1) % path.length;
            const subProgress = (progress % (100 / (path.length - 1))) / (100 / (path.length - 1));
            
            const currentPos = path[index];
            const nextPos = path[nextIndex];
            
            const x = currentPos.x + (nextPos.x - currentPos.x) * subProgress;
            const y = currentPos.y + (nextPos.y - currentPos.y) * subProgress;
            
            marker.style.transform = `translate(${x}px, ${y}px)`;
            
            // Dynamic ETA
            const minsLeft = Math.max(1, 8 - Math.floor(progress / 12));
            etaText.innerText = minsLeft + ' mins';
            
            if(minsLeft <= 2) {
                statusBadge.innerText = 'Almost There!';
                statusBadge.parentElement.classList.replace('bg-success', 'bg-warning');
            } else {
                statusBadge.innerText = 'Live Tracking';
                statusBadge.parentElement.classList.add('bg-success');
            }
        }

        setInterval(updateRider, 1000);
    });

    // Premium Location Suggestion Pills handler
    document.addEventListener('DOMContentLoaded', function() {
        const locInput = document.getElementById('location-input');
        const suggestionPills = document.querySelectorAll('.suggestion-pill');
        
        if (locInput && suggestionPills.length > 0) {
            suggestionPills.forEach(pill => {
                pill.addEventListener('click', function() {
                    const val = this.getAttribute('data-val');
                    locInput.value = val;
                    
                    // Add quick subtle pulse animation on the pill
                    this.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        this.style.transform = '';
                        locInput.closest('form').submit();
                    }, 120);
                });
            });
        }
    });
</script>

<style>
    .rider-pulse {
        position: absolute;
        top: 50%; left: 50%;
        transform: translate(-50%, -50%);
        width: 60px; height: 60px;
        background: rgba(255, 122, 0, 0.3);
        border-radius: 50%;
        animation: rider-pulse 2s infinite;
        z-index: -1;
    }
    @keyframes rider-pulse {
        0% { transform: translate(-50%, -50%) scale(0.5); opacity: 0.8; }
        100% { transform: translate(-50%, -50%) scale(1.5); opacity: 0; }
    }
    .tracking-step.active {
        background: rgba(255, 122, 0, 0.05);
        border-color: rgba(255, 122, 0, 0.2);
    }
    .shadow-float {
        box-shadow: 0 20px 40px rgba(0,0,0,0.4);
    }
</style>

<!-- 6. APP DOWNLOAD CTA -->
<section class="py-5 my-5">
    <div class="container">
        <div class="glass-card overflow-hidden">
            <div class="row g-0 align-items-center">
                <div class="col-lg-6 p-5 p-lg-5 text-center text-lg-start">
                    <h2 class="display-4 font-poppins fw-bold mb-3 text-white">Food in your <span class="text-gradient-orange">pocket.</span></h2>
                    <p class="fs-5 text-secondary mb-5">Download the FoodDash app for exclusive deals, faster ordering, and advanced tracking. Available on iOS and Android.</p>
                    
                    <div class="d-flex flex-wrap justify-content-center justify-content-lg-start gap-3">
                        <a href="#" class="btn btn-light rounded-pill px-4 py-3 d-flex align-items-center gap-2 shadow-lg">
                            <i class="fa-brands fa-apple fs-3"></i>
                            <div class="text-start lh-1">
                                <small class="d-block fw-bold" style="font-size:0.6rem">Download on the</small>
                                <span class="fw-bold fs-6">App Store</span>
                            </div>
                        </a>
                        <a href="#" class="btn btn-dark rounded-pill px-4 py-3 d-flex align-items-center gap-2 border border-secondary shadow-lg">
                            <i class="fa-brands fa-google-play fs-3 text-success"></i>
                            <div class="text-start lh-1">
                                <small class="d-block fw-bold text-muted" style="font-size:0.6rem">GET IT ON</small>
                                <span class="fw-bold text-white fs-6">Google Play</span>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 text-center position-relative">
                    <div class="position-absolute w-100 h-100 bg-gradient-radial z-0"></div>
                    <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?q=80&w=1000" class="img-fluid p-5 position-relative z-10" style="transform: rotate(5deg) scale(1.1); filter: drop-shadow(0 30px 40px rgba(0,0,0,0.8));">
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
