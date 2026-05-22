@extends('layouts.app')

@section('title', ($restaurant->name ?? 'Restaurant') . ' - FoodDash')

@section('styles')
<style>
    .restaurant-banner {
        height: 50vh;
        min-height: 400px;
        position: relative;
        overflow: hidden;
        margin-top: 76px; /* Offset for fixed navbar */
    }
    .restaurant-banner img {
        width: 100%; height: 100%; object-fit: cover;
    }
    .restaurant-banner::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(0deg, var(--bg-dark-1) 0%, rgba(15,15,15,0.3) 50%, rgba(15,15,15,0.8) 100%);
    }

    .info-card {
        background: rgba(22, 22, 22, 0.85);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid var(--glass-border);
        border-radius: 30px;
        padding: 40px;
        margin-top: -100px;
        position: relative;
        z-index: 10;
        box-shadow: 0 30px 60px rgba(0,0,0,0.6);
    }

    .info-logo {
        width: 120px; height: 120px;
        border-radius: 20px;
        border: 4px solid var(--bg-dark-1);
        position: absolute;
        top: -60px; left: 40px;
        background: var(--bg-dark-1);
        box-shadow: 0 10px 30px rgba(0,0,0,0.5);
    }

    .menu-nav {
        position: sticky;
        top: 76px;
        background: rgba(15, 15, 15, 0.9);
        backdrop-filter: blur(10px);
        z-index: 100;
        border-bottom: 1px solid var(--glass-border);
        padding: 15px 0;
        overflow-x: auto;
        white-space: nowrap;
    }
    .menu-nav::-webkit-scrollbar { display: none; }
    
    .menu-link {
        color: var(--text-muted);
        font-weight: 500;
        padding: 8px 20px;
        border-radius: 50px;
        transition: var(--transition-smooth);
        display: inline-block;
    }
    .menu-link.active, .menu-link:hover {
        background: rgba(255, 122, 0, 0.1);
        color: var(--accent-orange);
    }

    /* APPLE-LEVEL Food Cards */
    .food-card {
        background: linear-gradient(145deg, rgba(255,255,255,0.03) 0%, rgba(255,255,255,0.01) 100%);
        border: 1px solid var(--glass-border);
        border-radius: 30px;
        padding: 25px;
        display: flex;
        gap: 25px;
        transition: var(--transition-smooth);
        position: relative;
        overflow: hidden;
        align-items: center;
    }
    .food-card:hover {
        background: rgba(255,255,255,0.05);
        border-color: rgba(255, 122, 0, 0.2);
        transform: scale(1.02);
        box-shadow: 0 20px 40px rgba(0,0,0,0.4), 0 0 40px rgba(255, 122, 0, 0.05);
    }

    .fc-image {
        width: 150px; height: 150px;
        border-radius: 20px;
        overflow: hidden;
        flex-shrink: 0;
        box-shadow: 0 10px 20px rgba(0,0,0,0.3);
    }
    .fc-image img {
        width: 100%; height: 100%; object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.25, 0.8, 0.25, 1);
    }
    .food-card:hover .fc-image img {
        transform: scale(1.1) rotate(2deg);
    }

    .fc-content {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .fc-title {
        font-family: 'Poppins', sans-serif;
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 8px;
    }
    .fc-desc {
        color: var(--text-muted);
        font-size: 0.9rem;
        line-height: 1.4;
        margin-bottom: 15px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .fc-price {
        font-family: 'Poppins', sans-serif;
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--text-primary);
    }

    .fc-add-btn {
        background: rgba(255, 122, 0, 0.1);
        border: 1px solid rgba(255, 122, 0, 0.3);
        color: var(--accent-orange);
        width: 45px; height: 45px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.2rem;
        transition: var(--transition-bounce);
        cursor: pointer;
    }
    .food-card:hover .fc-add-btn {
        background: linear-gradient(135deg, var(--accent-orange), #FF5500);
        color: white;
        box-shadow: 0 10px 20px var(--glow-orange);
        transform: rotate(90deg);
    }

    @media (max-width: 768px) {
        .food-card { flex-direction: column; text-align: center; padding: 20px; }
        .fc-image { width: 100%; height: 200px; margin-bottom: 15px; }
        .info-card { padding: 30px 20px; margin-top: -60px; text-align: center; }
        .info-logo { position: static; margin: 0 auto 20px; }
        .fc-add-btn { width: 100%; border-radius: 50px; height: 45px; margin-top: 15px; }
        .food-card:hover .fc-add-btn { transform: none; }
        .fc-add-btn::after { content: ' Add to Cart'; font-size: 1rem; font-weight: 600; margin-left: 10px; font-family: 'Inter', sans-serif; }
    }
</style>
@endsection

@section('content')

<!-- Restaurant Banner -->
<div class="restaurant-banner">
    <img src="{{ $restaurant->banner ?? 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?q=80&w=2000' }}" alt="Banner">
</div>

<!-- Restaurant Info -->
<div class="container">
    <div class="info-card" data-aos="fade-up">
        <img src="{{ $restaurant->logo ?? 'https://ui-avatars.com/api/?name='.urlencode($restaurant->name ?? 'R').'&background=FF7A00&color=fff' }}" class="info-logo" alt="Logo">
        
        <div class="row align-items-center" style="margin-top: 40px; @media(min-width: 769px){ margin-top: 0; padding-left: 140px; }">
            <div class="col-lg-8">
                <div class="d-flex align-items-center gap-3 mb-2 justify-content-center justify-content-lg-start">
                    <h1 class="font-poppins m-0">{{ $restaurant->name ?? 'Gourmet Burger House' }}</h1>
                    <i class="fa-solid fa-circle-check text-primary fs-4" title="Verified Partner"></i>
                </div>
                <p class="text-secondary mb-4">{{ $restaurant->description ?? 'Premium American burgers made with 100% Angus beef, fresh brioche buns, and house-made secret sauces. Experience the ultimate burger.' }}</p>
                
                <div class="d-flex flex-wrap gap-4 justify-content-center justify-content-lg-start">
                    <div class="d-flex align-items-center gap-2">
                        <div class="bg-dark rounded-circle d-flex align-items-center justify-content-center" style="width:40px; height:40px;"><i class="fa-solid fa-star text-warning"></i></div>
                        <div><div class="fw-bold lh-1">{{ $restaurant->rating ?? '4.9' }}</div><small class="text-muted" style="font-size:0.7rem;">500+ Ratings</small></div>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <div class="bg-dark rounded-circle d-flex align-items-center justify-content-center" style="width:40px; height:40px;"><i class="fa-solid fa-clock text-orange"></i></div>
                        <div><div class="fw-bold lh-1">{{ $restaurant->delivery_time ?? '20-30' }} min</div><small class="text-muted" style="font-size:0.7rem;">Delivery Time</small></div>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <div class="bg-dark rounded-circle d-flex align-items-center justify-content-center" style="width:40px; height:40px;"><i class="fa-solid fa-motorcycle text-success"></i></div>
                        <div><div class="fw-bold lh-1">Free</div><small class="text-muted" style="font-size:0.7rem;">Delivery Fee</small></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                <button class="btn btn-glass-outline rounded-circle me-2" style="width:50px; height:50px; padding:0;"><i class="fa-solid fa-share-nodes"></i></button>
                <button class="btn btn-glass-outline rounded-circle me-2" style="width:50px; height:50px; padding:0;"><i class="fa-regular fa-heart"></i></button>
                <button class="btn btn-premium rounded-pill px-4"><i class="fa-solid fa-users me-2"></i> Group Order</button>
            </div>
        </div>
    </div>
</div>

<!-- Sticky Menu Navigation -->
<div class="menu-nav mt-5">
    <div class="container d-flex gap-2">
        @foreach($menu ?? [] as $categoryName => $products)
            <a href="#{{ Str::slug($categoryName) }}" class="menu-link {{ $loop->first ? 'active' : '' }}">{{ $categoryName }}</a>
        @endforeach
    </div>
</div>

<!-- Menu Sections -->
<div class="container py-5">
    <!-- Menu Sections -->
    @forelse($menu ?? [] as $categoryName => $products)
    <div id="{{ Str::slug($categoryName) }}" class="mb-5 pt-4">
        <h3 class="font-poppins mb-4 d-flex align-items-center gap-2">
            <i class="fa-solid fa-fire text-orange"></i> {{ $categoryName }}
        </h3>
        <div class="row g-4">
            @foreach($products as $product)
                <div class="col-lg-6" data-aos="fade-up">
                    <div class="food-card">
                        <div class="fc-image">
                            <img src="{{ $product->display_image }}" alt="{{ $product->name }}">
                        </div>
                        <div class="fc-content">
                            <div class="d-flex justify-content-between align-items-start">
                                <h4 class="fc-title">{{ $product->name }}</h4>
                            </div>
                            <p class="fc-desc">{{ Str::limit($product->description, 80) }}</p>
                            <div class="d-flex justify-content-between align-items-end mt-auto">
                                <div class="fc-price">PKR {{ number_format($product->price) }}</div>
                                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <button type="submit" class="fc-add-btn border-0"><i class="fa-solid fa-plus"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @empty
        <div class="alert alert-warning">No menu items available for this restaurant.</div>
    @endforelse
</div>

@endsection

@section('scripts')
<script>
    // Smooth scrolling for sticky menu
    document.querySelectorAll('.menu-link').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelectorAll('.menu-link').forEach(l => l.classList.remove('active'));
            this.classList.add('active');
            const targetId = this.getAttribute('href');
            if(targetId === '#') return;
            const targetElement = document.querySelector(targetId);
            if(targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 140,
                    behavior: 'smooth'
                });
            }
        });
    });
</script>
@endsection
