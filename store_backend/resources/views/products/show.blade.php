@extends('layouts.app')

@section('title', $product->name . ' - FoodDash Premium')

@section('styles')
<style>
    /* Premium Cinematic Overhaul for Product Detail */
    .product-detail-container {
        margin-top: 50px;
        padding-bottom: 80px;
    }

    /* Glassmorphic Breadcrumb */
    .glass-breadcrumb {
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.05);
        padding: 12px 24px;
        border-radius: 50px;
    }
    .breadcrumb-item a {
        color: rgba(255, 255, 255, 0.6) !important;
        transition: color 0.3s ease;
    }
    .breadcrumb-item a:hover {
        color: var(--accent-orange) !important;
    }
    .breadcrumb-item.active {
        color: var(--accent-orange) !important;
        font-weight: 600;
    }

    /* Cinematic Product Image Showcase */
    .product-showcase-card {
        background: linear-gradient(145deg, rgba(255, 255, 255, 0.04) 0%, rgba(255, 255, 255, 0.01) 100%);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 30px;
        overflow: hidden;
        position: relative;
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.6), inset 0 1px 0 rgba(255, 255, 255, 0.1);
        transition: all 0.5s ease;
    }
    .product-showcase-card:hover {
        border-color: rgba(255, 122, 0, 0.3);
        box-shadow: 0 30px 70px rgba(0, 0, 0, 0.7), 0 0 50px rgba(255, 122, 0, 0.1);
    }
    .product-showcase-card img {
        transition: transform 0.8s cubic-bezier(0.165, 0.84, 0.44, 1);
    }
    .product-showcase-card:hover img {
        transform: scale(1.05);
    }

    /* Right Column Details */
    .product-title {
        font-family: 'Poppins', sans-serif;
        font-weight: 800;
        font-size: 3rem;
        letter-spacing: -1.5px;
        line-height: 1.1;
        background: linear-gradient(to right, #FFFFFF 30%, rgba(255, 255, 255, 0.8) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .product-price-tag {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-size: 2.2rem;
        color: var(--accent-orange) !important;
        text-shadow: 0 0 25px rgba(255, 122, 0, 0.2);
    }
    .product-price-original {
        font-size: 1.4rem;
        color: rgba(255, 255, 255, 0.4);
        text-decoration: line-through;
        margin-left: 15px;
    }

    /* Quantity Control */
    .qty-group-frosted {
        border: 1px solid rgba(255, 255, 255, 0.08);
        background: rgba(255, 255, 255, 0.03);
        border-radius: 16px;
        padding: 5px;
        overflow: hidden;
    }
    .qty-btn-frosted {
        background: transparent;
        border: none;
        color: white;
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }
    .qty-btn-frosted:hover {
        background: rgba(255, 255, 255, 0.1);
        color: var(--accent-orange);
    }
    .qty-input-frosted {
        background: transparent !important;
        border: none !important;
        color: white !important;
        font-weight: bold;
        text-align: center;
        font-size: 1.1rem;
        width: 50px;
        box-shadow: none !important;
    }

    /* Premium Food-Card related */
    .related-food-card {
        background: linear-gradient(145deg, rgba(255, 255, 255, 0.03) 0%, rgba(255, 255, 255, 0.01) 100%);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 24px;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        position: relative;
    }
    .related-food-card:hover {
        background: rgba(255, 255, 255, 0.06);
        border-color: rgba(255, 122, 0, 0.2);
        transform: translateY(-8px);
        box-shadow: 0 20px 45px rgba(0, 0, 0, 0.5), 0 0 35px rgba(255, 122, 0, 0.06);
    }
    .related-image-container {
        height: 220px;
        overflow: hidden;
        position: relative;
    }
    .related-image-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
    }
    .related-food-card:hover .related-image-container img {
        transform: scale(1.08) rotate(1deg);
    }

    /* Custom neon status green */
    .pulse-dot-active {
        width: 8px; height: 8px; background: #00E676; border-radius: 50%;
        box-shadow: 0 0 10px #00E676;
        animation: active-pulse 2s infinite;
    }
    @keyframes active-pulse {
        0% { box-shadow: 0 0 0 0 rgba(0, 230, 118, 0.7); }
        70% { box-shadow: 0 0 0 6px rgba(0, 230, 118, 0); }
        100% { box-shadow: 0 0 0 0 rgba(0, 230, 118, 0); }
    }
</style>
@endsection

@section('content')
<div class="container product-detail-container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-5 animate__animated animate__fadeIn">
        <ol class="breadcrumb glass-breadcrumb d-inline-flex align-items-center mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}" class="text-decoration-none">Curated Menu</a></li>
            @if($product->category)
            <li class="breadcrumb-item"><a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="text-decoration-none">{{ $product->category->name }}</a></li>
            @endif
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row g-5">
        <!-- Product Showcase (Image) -->
        <div class="col-lg-6 animate__animated animate__fadeInLeft">
            <div class="product-showcase-card h-100 d-flex align-items-center justify-content-center" style="min-height: 480px; background: rgba(0,0,0,0.2);">
                <img src="{{ $product->display_image }}" class="w-100 h-100 object-fit-cover" style="min-height: 480px; max-height: 600px;" alt="{{ $product->name }}">
                
                @if($product->price < ($product->original_price ?? 0))
                    <div class="position-absolute top-0 start-0 m-4">
                        <span class="badge bg-danger rounded-pill px-4 py-2 fs-6 fw-bold shadow-lg">Exclusive Promo</span>
                    </div>
                @endif

                <div class="position-absolute top-0 end-0 m-4">
                    <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-glass-outline rounded-circle p-0 d-flex align-items-center justify-content-center hover-orange transition-smooth" style="width: 50px; height: 50px;" title="Save to Wishlist">
                            <i class="fa-solid fa-heart text-danger fs-5"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Product Information -->
        <div class="col-lg-6 animate__animated animate__fadeInRight d-flex flex-column justify-content-center">
            <div class="d-flex justify-content-between align-items-center mb-3">
                @if($product->category)
                <span class="badge bg-orange bg-opacity-10 text-orange border border-orange border-opacity-25 px-3 py-2 rounded-pill fw-bold text-uppercase tracking-wider small">{{ $product->category->name }}</span>
                @endif
                <div class="d-flex align-items-center gap-2 text-warning bg-glass border-glass px-3 py-1.5 rounded-pill">
                    <i class="fa-solid fa-star text-warning"></i>
                    <span class="text-white fw-bold text-opacity-90 small">4.9</span>
                    <span class="text-white text-opacity-50 small">(150+ reviews)</span>
                </div>
            </div>

            <h1 class="product-title font-poppins mb-3">{{ $product->name }}</h1>
            
            <div class="mb-4 d-flex align-items-center">
                <span class="product-price-tag">PKR {{ number_format($product->price, 0) }}</span>
                @if(isset($product->original_price) && $product->original_price > $product->price)
                <span class="product-price-original">PKR {{ number_format($product->original_price, 0) }}</span>
                @endif
            </div>

            <p class="fs-5 text-secondary mb-4 lh-lg">{{ $product->description }}</p>

            <!-- Food Availability Status -->
            <div class="mb-4">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06);">
                    <span class="fw-medium text-secondary me-1">Kitchen Status:</span>
                    @if($product->is_available)
                        <div class="pulse-dot-active"></div>
                        <span class="text-success fw-bold small">Freshly Prepared & Available</span>
                    @else
                        <div class="bg-danger rounded-circle" style="width: 8px; height: 8px; box-shadow: 0 0 10px #ff3d00;"></div>
                        <span class="text-danger fw-bold small">Kitchen Closed</span>
                    @endif
                </div>
            </div>

            <!-- Quantity & Add to Basket -->
            <div class="d-flex flex-wrap gap-3 mb-5 mt-2">
                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-flex gap-3 flex-grow-1 flex-wrap">
                    @csrf
                    <div class="qty-group-frosted d-flex align-items-center">
                        <button class="qty-btn-frosted" type="button" onclick="var inp = this.parentNode.querySelector('input[type=number]'); inp.stepDown();"><i class="fa-solid fa-minus"></i></button>
                        <input type="number" name="quantity" class="form-control qty-input-frosted" value="1" min="1" max="10">
                        <button class="qty-btn-frosted" type="button" onclick="var inp = this.parentNode.querySelector('input[type=number]'); inp.stepUp();"><i class="fa-solid fa-plus"></i></button>
                    </div>
                    <button type="submit" class="btn btn-premium flex-grow-1 rounded-3 py-3 fw-bold d-flex align-items-center justify-content-center gap-2 shadow-lg" {{ !$product->is_available ? 'disabled' : '' }}>
                        <i class="fa-solid fa-basket-shopping fs-5"></i> Add to Order Basket
                    </button>
                </form>
            </div>

            <!-- Premium Food-Specific Logistical Details Card -->
            <div class="card border-0 bg-glass text-white rounded-4 p-4 shadow-sm border border-secondary border-opacity-25" style="background: rgba(255,255,255,0.03); backdrop-filter: blur(10px);">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="bg-orange rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; min-width: 40px;">
                        <i class="fa-solid fa-fire text-white"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold text-white">Artisanal Gourmet Preparation</h6>
                        <small class="text-white-50">Handcrafted to order with absolute freshness in approximately {{ $product->preparation_time ?? '25' }} mins</small>
                    </div>
                </div>
                <hr class="border-secondary opacity-25">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="bg-success rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; min-width: 40px;">
                        <i class="fa-solid fa-truck-ramp-box text-white"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold text-white">High-Speed Insulated delivery</h6>
                        <small class="text-white-50">Dispatched in thermal-insulated containers across F-7, Blue Area, F-9, & Islamabad central vectors</small>
                    </div>
                </div>
                @if($product->restaurant)
                <hr class="border-secondary opacity-25">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-info rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; min-width: 40px;">
                        <i class="fa-solid fa-store text-white"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold text-white">Dispatched From Restaurant Hub</h6>
                        <small class="text-white-50">Prepared at <strong>{{ $product->restaurant->name }}</strong>, based in {{ $product->restaurant->address }}</small>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Related Delicacies -->
    @if($relatedProducts->count() > 0)
    <div class="mt-5 pt-5 animate__animated animate__fadeInUp">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h6 class="text-orange text-uppercase fw-bold tracking-wider mb-2">More Delicacies</h6>
                <h3 class="font-poppins text-white fw-bold mb-0">From {{ $product->restaurant->name ?? 'This Kitchen' }}</h3>
            </div>
        </div>
        <div class="row g-4">
            @foreach($relatedProducts as $related)
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="related-food-card h-100 d-flex flex-column">
                    <div class="related-image-container">
                        <img src="{{ $related->display_image }}" alt="{{ $related->name }}">
                        @if($related->price < ($related->original_price ?? 0))
                            <span class="badge bg-danger position-absolute top-0 start-0 m-3 px-3 py-1.5 rounded-pill" style="font-size:0.75rem;">Promo</span>
                        @endif
                    </div>
                    <div class="p-4 d-flex flex-column flex-grow-1">
                        @if($related->category)
                            <span class="text-orange text-uppercase small fw-bold tracking-wider" style="font-size:0.75rem;">{{ $related->category->name }}</span>
                        @endif
                        <h5 class="fw-bold text-white mt-2 mb-3 font-poppins text-truncate">
                            <a href="{{ route('products.show', $related->slug) }}" class="text-white text-decoration-none hover-orange">{{ $related->name }}</a>
                        </h5>
                        <div class="d-flex justify-content-between align-items-center mt-auto pt-3 border-top border-secondary border-opacity-10">
                            <span class="fw-bold text-white-50">PKR {{ number_format($related->price, 0) }}</span>
                            <form action="{{ route('cart.add', $related->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-premium rounded-circle p-2 shadow-sm d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;" {{ !$related->is_available ? 'disabled' : '' }}>
                                    <i class="fa-solid fa-plus fs-6 text-white"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
