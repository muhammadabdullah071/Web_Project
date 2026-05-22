@extends('layouts.app')

@section('title', 'Restaurants - FoodDash Premium')

@section('styles')
<style>
    .page-header {
        background: linear-gradient(135deg, var(--bg-dark-2) 0%, var(--bg-dark-1) 100%);
        padding: 120px 0 60px;
        position: relative;
        overflow: hidden;
    }
    .page-header::after {
        content: '';
        position: absolute;
        top: 0; right: 0;
        width: 50%; height: 100%;
        background: radial-gradient(circle at top right, rgba(255, 122, 0, 0.1), transparent 70%);
        z-index: 0;
    }
    
    .filter-panel {
        background: var(--glass-bg);
        border: 1px solid var(--glass-border);
        border-radius: 20px;
        padding: 24px;
        backdrop-filter: blur(16px);
        position: sticky;
        top: 100px;
    }

    .filter-title {
        font-family: 'Poppins', sans-serif;
        color: var(--text-primary);
        font-size: 1.1rem;
        margin-bottom: 15px;
        font-weight: 600;
        border-bottom: 1px solid var(--glass-border);
        padding-bottom: 10px;
    }

    .form-check-input:checked {
        background-color: var(--accent-orange);
        border-color: var(--accent-orange);
        box-shadow: 0 0 10px rgba(255, 122, 0, 0.5);
    }
    .form-check-label {
        color: var(--text-secondary);
        font-size: 0.95rem;
    }

    .restaurant-card {
        background: linear-gradient(145deg, rgba(255,255,255,0.03) 0%, rgba(255,255,255,0.01) 100%);
        border: 1px solid var(--glass-border);
        border-radius: 24px;
        overflow: hidden;
        transition: var(--transition-smooth);
        display: flex;
        flex-direction: column;
        height: 100%;
        cursor: pointer;
    }
    .restaurant-card:hover {
        transform: translateY(-8px);
        border-color: rgba(255, 122, 0, 0.3);
        box-shadow: 0 15px 35px rgba(255, 122, 0, 0.15), var(--shadow-float);
    }
    
    .rc-image {
        height: 220px;
        width: 100%;
        position: relative;
        overflow: hidden;
    }
    .rc-image img {
        width: 100%; height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.25, 0.8, 0.25, 1);
    }
    .restaurant-card:hover .rc-image img {
        transform: scale(1.08);
    }
    
    .rc-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, rgba(0,0,0,0) 50%, rgba(0,0,0,0.8) 100%);
        z-index: 1;
    }
    
    .rc-badges {
        position: absolute;
        top: 15px; left: 15px; right: 15px;
        display: flex; justify-content: space-between;
        z-index: 2;
    }
    
    .rc-logo {
        position: absolute;
        bottom: -25px;
        right: 20px;
        width: 60px; height: 60px;
        border-radius: 15px;
        background: var(--bg-dark-1);
        padding: 5px;
        z-index: 3;
        box-shadow: 0 5px 15px rgba(0,0,0,0.5);
    }

    .rc-content {
        padding: 35px 20px 20px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .rc-title {
        font-family: 'Poppins', sans-serif;
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 5px;
        color: var(--text-primary);
    }

    .rc-meta {
        color: var(--text-muted);
        font-size: 0.85rem;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .search-box-large {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 15px;
        padding: 15px 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        backdrop-filter: blur(10px);
        margin-bottom: 30px;
    }
    .search-box-large input {
        background: transparent; border: none; color: white; width: 100%; outline: none; font-size: 1.1rem;
    }
    .hover-orange {
        color: rgba(255, 255, 255, 0.6) !important;
        transition: all 0.2s ease;
    }
    .hover-orange:hover {
        color: #FF7A00 !important;
        text-shadow: 0 0 10px rgba(255, 122, 0, 0.5);
    }
</style>
@endsection

@section('content')

<!-- Header -->
<header class="page-header">
    <div class="container position-relative z-10">
        <div class="row align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <span class="badge bg-orange px-3 py-2 rounded-pill mb-3 text-dark fw-bold">Explore</span>
                <h1 class="display-4 font-poppins text-white mb-3">Premium Partners</h1>
                <p class="text-secondary fs-5">Discover the finest culinary experiences around you. Handpicked for perfection.</p>
            </div>
            <div class="col-lg-6 text-lg-end" data-aos="fade-left">
                <img src="https://images.unsplash.com/photo-1544148103-0773bf10d330?q=80&w=1000" class="img-fluid rounded-4xl shadow-float border border-secondary border-opacity-25" style="max-height: 250px; object-fit:cover;">
            </div>
        </div>
    </div>
</header>

<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Sidebar Filters -->
            <div class="col-lg-3 mb-5 mb-lg-0" data-aos="fade-up">
                <div class="filter-panel position-sticky" style="top: 100px;">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="font-poppins mb-0"><i class="fa-solid fa-sliders text-orange me-2"></i>Filters</h4>
                        <a href="{{ route('restaurants.index') }}" class="small text-decoration-none hover-orange">Reset</a>
                    </div>
                    
                    <form action="{{ route('restaurants.index') }}" method="GET">
                        <!-- Category Filter -->
                        <h6 class="filter-title mt-4">Categories</h6>
                        <div class="d-flex flex-column gap-2">
                            @foreach($categories ?? [] as $category)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="categories[]" value="{{ $category->id }}" id="cat{{ $category->id }}" {{ in_array($category->id, request('categories', [])) ? 'checked' : '' }} onchange="this.form.submit()">
                                <label class="form-check-label d-flex justify-content-between" for="cat{{ $category->id }}">
                                    <span>{{ $category->name }}</span>
                                </label>
                            </div>
                            @endforeach
                            <!-- Fallback Demo Filters -->
                            @if(!isset($categories) || $categories->isEmpty())
                                <div class="form-check"><input class="form-check-input" type="checkbox" id="c1"><label class="form-check-label">Burgers & Fast Food</label></div>
                                <div class="form-check"><input class="form-check-input" type="checkbox" id="c2"><label class="form-check-label">Sushi & Japanese</label></div>
                                <div class="form-check"><input class="form-check-input" type="checkbox" id="c3"><label class="form-check-label">Italian & Pizza</label></div>
                                <div class="form-check"><input class="form-check-input" type="checkbox" id="c4"><label class="form-check-label">Healthy & Salads</label></div>
                            @endif
                        </div>

                        <!-- Rating Filter -->
                        <h6 class="filter-title mt-4">Minimum Rating</h6>
                        <div class="d-flex flex-column gap-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="rating" id="r4" value="4" {{ request('rating') == '4' ? 'checked' : '' }} onchange="this.form.submit()">
                                <label class="form-check-label text-warning" for="r4">
                                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-regular fa-star text-muted"></i> & Up
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="rating" id="r45" value="4.5" {{ request('rating') == '4.5' ? 'checked' : '' }} onchange="this.form.submit()">
                                <label class="form-check-label text-warning" for="r45">
                                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i> & Up
                                </label>
                            </div>
                        </div>

                        <!-- Delivery Time Filter -->
                        <h6 class="filter-title mt-4">Delivery Time</h6>
                        <div class="d-flex flex-column gap-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="time" id="t1" value="30" {{ request('time') == '30' ? 'checked' : '' }} onchange="this.form.submit()">
                                <label class="form-check-label" for="t1">Under 30 mins</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="time" id="t2" value="45" {{ request('time') == '45' ? 'checked' : '' }} onchange="this.form.submit()">
                                <label class="form-check-label" for="t2">Under 45 mins</label>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Restaurant Grid -->
            <div class="col-lg-9">
                <!-- Search Bar -->
                <form action="{{ route('restaurants.index') }}" method="GET" class="search-box-large" data-aos="fade-down">
                    @if(request('categories'))
                        @foreach(request('categories') as $catId)
                            <input type="hidden" name="categories[]" value="{{ $catId }}">
                        @endforeach
                    @endif
                    @if(request('rating')) <input type="hidden" name="rating" value="{{ request('rating') }}"> @endif
                    @if(request('time')) <input type="hidden" name="time" value="{{ request('time') }}"> @endif
                    
                    <i class="fa-solid fa-magnifying-glass text-orange fs-4"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search for restaurants, cuisines, or a specific dish...">
                    <button type="submit" class="btn btn-premium rounded-pill px-4">Search</button>
                </form>

                <!-- Active Filters Tags -->
                <div class="d-flex flex-wrap gap-2 mb-4">
                    @if(request('search'))
                        <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}" class="badge bg-glass border border-secondary px-3 py-2 rounded-pill fw-normal text-secondary text-decoration-none hover-orange">
                            Search: {{ request('search') }} <i class="fa-solid fa-xmark ms-2"></i>
                        </a>
                    @endif
                    
                    @if(request('categories'))
                        @foreach($categories as $category)
                            @if(in_array($category->id, request('categories')))
                                <a href="{{ request()->fullUrlWithQuery(['categories' => array_diff(request('categories'), [$category->id])]) }}" class="badge bg-glass border border-secondary px-3 py-2 rounded-pill fw-normal text-secondary text-decoration-none hover-orange">
                                    {{ $category->name }} <i class="fa-solid fa-xmark ms-2"></i>
                                </a>
                            @endif
                        @endforeach
                    @endif

                    @if(request('rating'))
                        <a href="{{ request()->fullUrlWithQuery(['rating' => null]) }}" class="badge bg-glass border border-secondary px-3 py-2 rounded-pill fw-normal text-secondary text-decoration-none hover-orange">
                            <i class="fa-solid fa-star text-warning me-1"></i> {{ request('rating') }}+ <i class="fa-solid fa-xmark ms-2"></i>
                        </a>
                    @endif

                    @if(request('time'))
                        <a href="{{ request()->fullUrlWithQuery(['time' => null]) }}" class="badge bg-glass border border-secondary px-3 py-2 rounded-pill fw-normal text-secondary text-decoration-none hover-orange">
                            <i class="fa-solid fa-clock text-orange me-1"></i> Under {{ request('time') }} min <i class="fa-solid fa-xmark ms-2"></i>
                        </a>
                    @endif
                </div>

                <div class="row g-4">
                    @forelse($restaurants ?? [] as $restaurant)
                    <div class="col-md-6 col-xl-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <a href="{{ route('restaurants.show', $restaurant->slug) }}" class="text-decoration-none">
                            <div class="restaurant-card">
                                <div class="rc-image">
                                    <img src="{{ $restaurant->display_image }}" alt="{{ $restaurant->name }}">
                                    <div class="rc-overlay"></div>
                                    <div class="rc-badges">
                                        <span class="badge bg-dark border border-secondary px-3 py-2 rounded-pill d-flex align-items-center gap-1 shadow-sm">
                                            <i class="fa-solid fa-clock text-orange"></i> {{ $restaurant->delivery_time ?? '25' }} min
                                        </span>
                                        <button class="btn btn-glass rounded-circle p-0 d-flex align-items-center justify-content-center" style="width:35px; height:35px;" onclick="event.preventDefault(); this.querySelector('i').classList.toggle('fa-regular'); this.querySelector('i').classList.toggle('fa-solid'); this.querySelector('i').classList.toggle('text-danger'); this.querySelector('i').classList.toggle('text-white');">
                                            <i class="fa-regular fa-heart text-white"></i>
                                        </button>
                                    </div>
                                    <img src="{{ $restaurant->logo ?? 'https://cdn-icons-png.flaticon.com/512/3448/3448011.png' }}" class="rc-logo bg-dark" style="object-fit:contain; padding: 10px;">
                                </div>
                                <div class="rc-content">
                                    <h3 class="rc-title text-truncate">{{ $restaurant->name }}</h3>
                                    <div class="rc-meta">
                                        <span><i class="fa-solid fa-utensils me-1 text-orange"></i> {{ $restaurant->cuisine_type ?? 'Multi-Cuisine' }}</span>
                                        <span><i class="fa-solid fa-star text-warning me-1"></i> <span class="text-white fw-bold">{{ $restaurant->rating ?? '4.8' }}</span></span>
                                    </div>
                                    <div class="mt-auto pt-3 border-top border-secondary border-opacity-25 d-flex justify-content-between align-items-center">
                                        <span class="text-secondary small"><i class="fa-solid fa-motorcycle text-orange me-1"></i> Free Delivery</span>
                                        <span class="text-orange small fw-bold">$$$</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @empty
                        <!-- Static Demo Content if DB is empty -->
                        @php
                            $demos = [
                                ['name' => 'Burger Atelier', 'img' => 'https://images.unsplash.com/photo-1550547660-d9450f859349?q=80&w=1000', 'type' => 'American • Burgers'],
                                ['name' => 'Sakura Sushi Bar', 'img' => 'https://images.unsplash.com/photo-1579871494447-9811cf80d66c?q=80&w=1000', 'type' => 'Japanese • Sushi'],
                                ['name' => 'La Dolce Vita', 'img' => 'https://images.unsplash.com/photo-1604382354936-07c5d9983bd3?q=80&w=1000', 'type' => 'Italian • Pizza'],
                                ['name' => 'Spice Symphony', 'img' => 'https://images.unsplash.com/photo-1585937421612-70a008356fbe?q=80&w=1000', 'type' => 'Indian • Curries'],
                                ['name' => 'Green Bowl', 'img' => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?q=80&w=1000', 'type' => 'Healthy • Salads'],
                                ['name' => 'Taco Fiesta', 'img' => 'https://images.unsplash.com/photo-1565299585323-38d6b0865b47?q=80&w=1000', 'type' => 'Mexican • Tacos'],
                            ];
                        @endphp
                        @foreach($demos as $k => $demo)
                        <div class="col-md-6 col-xl-4" data-aos="fade-up" data-aos-delay="{{ $k * 100 }}">
                            <a href="#" class="text-decoration-none">
                                <div class="restaurant-card">
                                    <div class="rc-image">
                                        <img src="{{ $demo['img'] }}" alt="Food">
                                        <div class="rc-overlay"></div>
                                        <div class="rc-badges">
                                            <span class="badge bg-dark border border-secondary px-3 py-2 rounded-pill d-flex align-items-center gap-1"><i class="fa-solid fa-clock text-orange"></i> 20-30 min</span>
                                            <button class="btn btn-glass rounded-circle p-0 d-flex align-items-center justify-content-center" style="width:35px; height:35px;"><i class="fa-regular fa-heart text-white"></i></button>
                                        </div>
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($demo['name']) }}&background=1E1E1E&color=FF7A00" class="rc-logo">
                                    </div>
                                    <div class="rc-content">
                                        <h3 class="rc-title text-truncate">{{ $demo['name'] }}</h3>
                                        <div class="rc-meta">
                                            <span>{{ $demo['type'] }}</span>
                                            <span><i class="fa-solid fa-star text-warning me-1"></i> <span class="text-white fw-bold">4.9</span> (500+)</span>
                                        </div>
                                        <div class="mt-auto pt-3 border-top border-secondary border-opacity-25 d-flex justify-content-between align-items-center">
                                            <span class="text-secondary small"><i class="fa-solid fa-motorcycle text-orange me-1"></i> Free Delivery</span>
                                            <span class="text-orange small fw-bold">$$</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    @endforelse
                </div>

                <!-- Next/Previous Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-5">
                    <a href="{{ $restaurants->previousPageUrl() }}" class="btn btn-glass-outline rounded-pill px-4 {{ $restaurants->onFirstPage() ? 'disabled opacity-25' : '' }}">
                        <i class="fa-solid fa-chevron-left me-2"></i> Previous
                    </a>
                    <span class="text-muted small">Page {{ $restaurants->currentPage() }}</span>
                    <a href="{{ $restaurants->nextPageUrl() }}" class="btn btn-glass-outline rounded-pill px-4 {{ !$restaurants->hasMorePages() ? 'disabled opacity-25' : '' }}">
                        Next <i class="fa-solid fa-chevron-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
