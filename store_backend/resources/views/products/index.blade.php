@extends('layouts.app')

@section('title', 'Collections - Premium Export')

@section('content')
<div class="container py-5 mt-5">
    <div class="row align-items-center mb-5">
        <div class="col-md-6">
            <h1 class="text-gold display-4">Collections</h1>
            <p class="text-secondary">Explore our curated selection of premium garments.</p>
        </div>
        <div class="col-md-6 text-md-end">
            <div class="dropdown d-inline-block">
                <button class="btn btn-glass dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    Sort By
                </button>
                <ul class="dropdown-menu dropdown-menu-dark bg-dark border-secondary">
                    <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}">Newest</a></li>
                    <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'price_low']) }}">Price: Low to High</a></li>
                    <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'price_high']) }}">Price: High to Low</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Sidebar Filters -->
        <div class="col-lg-3 mb-4">
            <div class="glass-card p-4">
                <h5 class="mb-4">Categories</h5>
                <div class="list-group list-group-flush bg-transparent">
                    <a href="{{ route('products.index') }}" class="list-group-item bg-transparent text-{{ !request('category') ? 'gold' : 'secondary' }} border-0 px-0">All Products</a>
                    @foreach($categories as $category)
                        <a href="{{ route('products.index', ['category' => $category->slug]) }}" 
                           class="list-group-item bg-transparent text-{{ request('category') == $category->slug ? 'gold' : 'secondary' }} border-0 px-0">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Product Grid -->
        <div class="col-lg-9">
            <div class="row">
                @forelse($products as $product)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="glass-card h-100">
                            <div class="product-img-wrapper">
                                <a href="{{ route('products.show', $product->slug) }}">
                                    <img src="{{ $product->display_image }}" alt="{{ $product->name }}">
                                </a>
                            </div>
                            <div class="product-info">
                                <a href="{{ route('products.show', $product->slug) }}">
                                    <h3 class="product-title">{{ $product->name }}</h3>
                                </a>
                                <p class="text-secondary mb-2 small text-truncate">{{ $product->description }}</p>
                                <div class="product-price">
                                    @if($product->sale_price)
                                        <span class="text-decoration-line-through text-secondary small me-2">${{ $product->price }}</span>
                                        ${{ $product->sale_price }}
                                    @else
                                        ${{ $product->price }}
                                    @endif
                                </div>
                            </div>
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="quick-add-btn w-100 border-0">Add to Cart</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <h3 class="text-secondary">No products found matching your criteria.</h3>
                    </div>
                @endforelse
            </div>

            <!-- Next/Previous Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-5 custom-pagination">
                <a href="{{ $products->previousPageUrl() }}" class="btn btn-glass-outline rounded-pill px-4 {{ $products->onFirstPage() ? 'disabled opacity-25' : '' }}">
                    <i class="fa-solid fa-chevron-left me-2"></i> Previous
                </a>
                <span class="text-muted small">Page {{ $products->currentPage() }}</span>
                <a href="{{ $products->nextPageUrl() }}" class="btn btn-glass-outline rounded-pill px-4 {{ !$products->hasMorePages() ? 'disabled opacity-25' : '' }}">
                    Next <i class="fa-solid fa-chevron-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .product-img-wrapper {
        position: relative;
        overflow: hidden;
        border-radius: 15px;
        margin-bottom: 15px;
    }
    .product-img-wrapper img {
        width: 100%;
        height: 220px;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .glass-card:hover .product-img-wrapper img {
        transform: scale(1.08);
    }
    .product-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 8px;
        color: #fff;
    }
    
    /* Dark Theme Pagination */
    .custom-pagination .pagination {
        gap: 5px;
    }
    .custom-pagination .page-item .page-link {
        background-color: var(--glass-bg);
        border: 1px solid var(--glass-border);
        color: var(--text-secondary);
        border-radius: 8px;
        padding: 8px 16px;
        transition: all 0.3s ease;
    }
    .custom-pagination .page-item.active .page-link {
        background-color: var(--accent-orange);
        border-color: var(--accent-orange);
        color: #fff;
        box-shadow: 0 0 15px rgba(255, 122, 0, 0.4);
    }
    .custom-pagination .page-item .page-link:hover:not(.active) {
        background-color: rgba(255, 255, 255, 0.1);
        color: #fff;
    }
    .custom-pagination .page-item.disabled .page-link {
        background-color: rgba(255, 255, 255, 0.02);
        color: rgba(255, 255, 255, 0.2);
        border-color: rgba(255, 255, 255, 0.05);
    }
</style>
@endsection
