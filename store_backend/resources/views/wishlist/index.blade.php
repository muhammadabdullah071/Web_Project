@extends('layouts.app')

@section('title', 'My Wishlist - FoodDash Premium')

@section('content')
<div class="container py-5 mt-4">
    <div class="d-flex justify-content-between align-items-center mb-5" data-aos="fade-down">
        <div>
            <h1 class="font-poppins text-white fw-bold"><i class="fa-solid fa-heart text-orange me-3"></i>My Wishlist</h1>
            <p class="text-secondary">Your collection of premium saved dishes.</p>
        </div>
        <a href="{{ route('products.index') }}" class="btn btn-glass-outline rounded-pill px-4"><i class="fa-solid fa-plus me-2"></i> Add More</a>
    </div>

    @if(session('success'))
        <div class="alert bg-success bg-opacity-25 border border-success text-white rounded-3 mb-4 animate__animated animate__fadeIn">
            <i class="fa-solid fa-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="row g-4">
        @forelse($wishlists as $item)
            @if($item->product)
            <div class="col-md-6 col-lg-4 col-xl-3" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="glass-card product-card h-100 rounded-4 border-glass overflow-hidden position-relative">
                    
                    <!-- Remove Button -->
                    <form action="{{ route('wishlist.toggle', $item->product_id) }}" method="POST" class="position-absolute top-0 end-0 m-3 z-index-10">
                        @csrf
                        <button type="submit" class="btn btn-danger rounded-circle p-0 d-flex align-items-center justify-content-center shadow-lg" style="width:35px; height:35px;" title="Remove from wishlist">
                            <i class="fa-solid fa-trash-can text-white" style="font-size: 0.8rem;"></i>
                        </button>
                    </form>

                    <div class="product-img-wrapper" style="height: 200px; overflow: hidden;">
                        <img src="{{ $item->product->display_image }}" class="w-100 h-100 object-fit-cover transition-transform" alt="{{ $item->product->name }}">
                    </div>
                    
                    <div class="p-4 d-flex flex-column h-100">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="font-poppins fw-bold text-white mb-0 text-truncate pe-2">{{ $item->product->name }}</h5>
                            <span class="text-orange fw-bold">PKR {{ number_format($item->product->display_price, 0) }}</span>
                        </div>
                        
                        <p class="text-muted small mb-4 line-clamp-2" style="font-size: 0.85rem;">{{ $item->product->description }}</p>
                        
                        <div class="mt-auto d-flex gap-2">
                            <form action="{{ route('cart.add', $item->product_id) }}" method="POST" class="flex-grow-1">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-premium w-100 rounded-pill py-2 text-uppercase tracking-wider small fw-bold">
                                    <i class="fa-solid fa-cart-plus me-2"></i> Move to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        @empty
            <div class="col-12 text-center py-5 my-5" data-aos="zoom-in">
                <div class="d-inline-block bg-dark border border-secondary border-opacity-25 rounded-circle p-5 mb-4 shadow-lg">
                    <i class="fa-regular fa-heart display-1 text-secondary opacity-50"></i>
                </div>
                <h3 class="font-poppins text-white">Your wishlist is empty</h3>
                <p class="text-muted mb-4">You haven't saved any premium dishes yet.</p>
                <a href="{{ route('products.index') }}" class="btn btn-premium rounded-pill px-5 py-3 fs-5">Explore Menu</a>
            </div>
        @endforelse
    </div>
</div>
@endsection
