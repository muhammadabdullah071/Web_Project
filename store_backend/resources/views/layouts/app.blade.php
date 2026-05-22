<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'FoodDash | Premium Food Delivery')</title>
    
    <!-- Premium Orange Bolt Favicon -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none'%3E%3Cpath d='M13 2L3 14H12L11 22L21 10H12L13 2Z' fill='%23FF7A00' stroke='%23FF9A3C' stroke-width='1.5' stroke-linejoin='round'/%3E%3C/svg%3E">

    <!-- Fonts: Inter for body, Poppins for headings -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Icons & Bootstrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    
    <!-- Animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <style>
        /* Specific Navbar Styles */
        .navbar-premium {
            background: rgba(15, 15, 15, 0.8) !important;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--glass-border);
            padding: 18px 0;
            transition: all 0.3s ease;
        }
        .navbar-premium.scrolled {
            padding: 12px 0;
            background: rgba(10, 10, 10, 0.95) !important;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }
        .navbar-brand {
            font-family: 'Poppins', sans-serif;
            font-weight: 800;
            font-size: 2rem;
            letter-spacing: -1px;
            color: #fff !important;
        }
        .nav-link {
            font-family: 'Inter', sans-serif;
            font-weight: 500;
            font-size: 1rem;
            color: var(--text-secondary) !important;
            margin: 0 10px;
            transition: var(--transition-smooth);
            position: relative;
        }
        .nav-link:hover, .nav-link.active {
            color: var(--accent-orange) !important;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0; height: 2px;
            bottom: 0; left: 50%;
            background: var(--accent-orange);
            transition: var(--transition-smooth);
            transform: translateX(-50%);
        }
        .nav-link:hover::after, .nav-link.active::after {
            width: 80%;
        }

        /* Cart Badge Pulse */
        .cart-badge {
            position: absolute;
            top: -5px; right: -8px;
            background: var(--accent-orange);
            color: white;
            font-size: 0.7rem;
            font-weight: bold;
            padding: 3px 6px;
            border-radius: 50px;
            border: 2px solid var(--bg-dark-1);
        }

        /* Floating QR Button */
        .qr-floating {
            position: fixed;
            bottom: 30px; right: 30px;
            width: 65px; height: 65px;
            background: linear-gradient(135deg, var(--accent-orange), #FF4500);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: white; font-size: 1.8rem;
            box-shadow: 0 10px 25px var(--glow-orange-strong);
            cursor: pointer;
            z-index: 1000;
            transition: var(--transition-bounce);
        }
        .qr-floating:hover {
            transform: translateY(-10px) scale(1.1) rotate(5deg);
            box-shadow: 0 15px 35px rgba(255, 69, 0, 0.6);
        }

        /* Footer */
        .footer-premium {
            background: var(--bg-dark-1);
            border-top: 1px solid var(--glass-border);
            padding-top: 80px; padding-bottom: 30px;
        }
        .footer-link {
            color: var(--text-secondary);
            transition: 0.3s;
            text-decoration: none;
            display: block; margin-bottom: 12px;
        }
        .footer-link:hover {
            color: var(--accent-orange);
            transform: translateX(5px);
        }

        /* Mobile App Nav */
        .mobile-nav {
            background: rgba(22, 22, 22, 0.95);
            backdrop-filter: blur(15px);
            border-top: 1px solid var(--glass-border);
            padding: 10px 0;
            z-index: 9999;
            pointer-events: auto;
            border-radius: 20px 20px 0 0;
        }
        .mobile-nav-item {
            color: var(--text-muted);
            text-decoration: none;
            display: flex; flex-direction: column; align-items: center;
            font-size: 0.75rem; transition: 0.3s;
        }
        .mobile-nav-item i { font-size: 1.4rem; margin-bottom: 4px; transition: 0.3s; }
        .mobile-nav-item.active { color: var(--accent-orange); }
        .mobile-nav-item.active i { transform: translateY(-3px); }
    </style>
    @yield('styles')
</head>
<body>

    <!-- Live Status Ticker -->
    <div class="status-ticker py-2 bg-black border-bottom border-white border-opacity-5 d-none d-md-block">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-4">
                    <div class="d-flex align-items-center gap-2">
                        <span class="status-dot-green"></span>
                        <span class="text-secondary fw-bold" style="font-size:0.6rem; letter-spacing: 1px;">STATUS: <span class="text-white">TAKING ORDERS</span></span>
                    </div>
                    <div class="vr bg-white opacity-10 mx-2" style="height: 10px;"></div>
                    <div class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-fire text-orange" style="font-size:0.7rem;"></i>
                        <span class="text-secondary fw-bold" style="font-size:0.6rem; letter-spacing: 1px;">HOT NOW: <span class="text-white">FREE DELIVERY OVER PKR 2000!</span></span>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <span class="text-white-50 fw-bold" style="font-size:0.6rem; letter-spacing: 1px;">YOUR FOOD, DELIVERED FAST & SAFE</span>
                    <i class="fa-solid fa-heart text-danger" style="font-size:0.7rem;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Navbar -->
    @if(!isset($hideNavbar) || !$hideNavbar)
    <nav class="navbar navbar-expand-lg navbar-premium fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ url('/') }}">
                <i class="fa-solid fa-bolt text-orange"></i>
                <span>Food<span class="text-orange">Dash</span></span>
            </a>
            
            <button class="navbar-toggler border-0 shadow-none text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <i class="fa-solid fa-bars-staggered fs-3"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('restaurants*') ? 'active' : '' }}" href="{{ route('restaurants.index') }}">Elite Discover</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('products*') ? 'active' : '' }}" href="{{ route('products.index') }}">Curated Menu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('offers*') ? 'active' : '' }}" href="{{ route('offers') }}">Exclusive Offers <span class="badge bg-danger ms-1" style="font-size:0.6rem">PLATINUM</span></a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-3">
                    @if(!auth()->check() || (auth()->user()->role !== 'admin' && auth()->user()->role !== 'owner'))
                    <!-- Global Search -->
                    <button class="btn btn-link text-white text-decoration-none px-2 fs-5 hover-orange transition-smooth" data-bs-toggle="modal" data-bs-target="#searchModal" title="Search Dishes or Restaurants">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>

                    <!-- Cart -->
                    <a href="{{ route('cart.index') }}" class="btn btn-link text-white text-decoration-none position-relative px-2 fs-5 hover-orange transition-smooth">
                        <i class="fa-solid fa-bag-shopping"></i>
                        @if(($cart_count ?? 0) > 0)
                            <span class="cart-badge animate-pulse-glow">{{ $cart_count }}</span>
                        @endif
                    </a>
                    @endif

                    <!-- User Auth -->
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-glass-outline btn-sm ms-2">Log In</a>
                        <a href="{{ route('register') }}" class="btn btn-premium btn-sm ms-2">Sign Up</a>
                    @else
                        <div class="dropdown ms-2">
                            <button class="btn btn-glass-outline d-flex align-items-center gap-2 dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=FF7A00&color=fff" class="rounded-circle" width="24" height="24" alt="User">
                                <span class="d-none d-md-inline">
                                    {{ explode(' ', Auth::user()->name)[0] }} 
                                    <small class="text-white-50 ms-1 fw-normal" style="font-size: 0.7rem;">({{ ucfirst(Auth::user()->role) }})</small>
                                </span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end glass-card p-2 border-glass mt-3 shadow-lg" style="z-index: 1050;">
                                @if(Auth::user()->is_admin || Auth::user()->role === \App\Models\User::ROLE_ADMIN || Auth::user()->role === \App\Models\User::ROLE_OWNER)
                                    <li><a class="dropdown-item rounded py-2" href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-gauge-high text-orange me-2"></i> Platform Control Center</a></li>
                                @endif
                                @if(Auth::user()->role === \App\Models\User::ROLE_RIDER)
                                    <li><a class="dropdown-item rounded py-2" href="{{ route('rider.dashboard') }}"><i class="fa-solid fa-motorcycle text-orange me-2"></i> Rider Dashboard</a></li>
                                @endif
                                <li><a class="dropdown-item rounded py-2" href="{{ route('orders.index') }}"><i class="fa-solid fa-clock-rotate-left text-orange me-2"></i> Order History</a></li>
                                <li><a class="dropdown-item rounded py-2" href="{{ route('wishlist.index') }}"><i class="fa-solid fa-heart text-orange me-2"></i> Saved Wishlist</a></li>
                                <li><hr class="dropdown-divider border-secondary opacity-25"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item rounded py-2 text-danger"><i class="fa-solid fa-arrow-right-from-bracket me-2"></i> Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </nav>
    @endif

    <!-- Main Content -->
    <main style="padding-top: 76px;">
        @yield('content')
    </main>

    <!-- Premium Footer -->
    @if(!isset($hideFooter) || !$hideFooter)
    <footer class="footer-premium">
        <div class="container">
            <div class="row g-5 mb-5">
                <div class="col-lg-4 pe-lg-5">
                    <a class="navbar-brand d-flex align-items-center gap-2 mb-4" href="{{ url('/') }}">
                        <i class="fa-solid fa-bolt text-orange fs-2"></i>
                        <span class="fs-2">Food<span class="text-orange">Dash</span></span>
                    </a>
                    <p class="text-secondary mb-4 pe-lg-4">
                        The future of food delivery is here. Experience ultra-fast, reliable, and premium food delivery tailored for the modern lifestyle.
                    </p>
                    <div class="d-flex gap-3">
                        <a href="#" class="btn btn-glass-outline rounded-circle social-icon-hover" style="width: 45px; height: 45px; padding: 0; display: flex; align-items: center; justify-content: center; color: #1DA1F2;"><i class="fa-brands fa-twitter fs-5"></i></a>
                        <a href="#" class="btn btn-glass-outline rounded-circle social-icon-hover" style="width: 45px; height: 45px; padding: 0; display: flex; align-items: center; justify-content: center; color: #E4405F;"><i class="fa-brands fa-instagram fs-5"></i></a>
                        <a href="#" class="btn btn-glass-outline rounded-circle social-icon-hover" style="width: 45px; height: 45px; padding: 0; display: flex; align-items: center; justify-content: center; color: #0077B5;"><i class="fa-brands fa-linkedin-in fs-5"></i></a>
                    </div>
                </div>
                
                <div class="col-6 col-lg-2">
                    <h5 class="text-white font-poppins mb-4">Company</h5>
                    <a href="#" class="footer-link">About Us</a>
                    <a href="#" class="footer-link">Careers</a>
                    <a href="#" class="footer-link">Blog</a>
                    <a href="#" class="footer-link">Press</a>
                </div>

                <div class="col-6 col-lg-2">
                    <h5 class="text-white font-poppins mb-4">Enterprise</h5>
                    <a href="{{ route('restaurants.index') }}" class="footer-link">Platform Network</a>
                    <a href="{{ route('offers') }}" class="footer-link">Executive Offers</a>
                    <a href="#" class="footer-link">Partner with Us</a>
                    <a href="{{ route('help') }}" class="footer-link">24/7 Digital Concierge</a>
                </div>

                <div class="col-lg-4">
                    <h5 class="text-white font-poppins mb-4">Download App</h5>
                    <p class="text-secondary mb-3">Get the full experience on your device.</p>
                    <div class="d-flex flex-column gap-3">
                        <a href="#" class="btn btn-glass-outline text-start d-flex align-items-center gap-3 py-2 px-4 rounded-4xl app-btn-premium position-relative overflow-hidden">
                            <i class="fa-brands fa-apple fs-2 text-white"></i>
                            <div>
                                <div class="small text-secondary" style="font-size: 0.7rem; line-height: 1;">Download on the</div>
                                <div class="fw-bold text-white fs-6">App Store</div>
                            </div>
                        </a>
                        <a href="#" class="btn btn-glass-outline text-start d-flex align-items-center gap-3 py-2 px-4 rounded-4xl app-btn-premium position-relative overflow-hidden">
                            <i class="fa-brands fa-google-play fs-2 text-white"></i>
                            <div>
                                <div class="small text-secondary" style="font-size: 0.7rem; line-height: 1;">GET IT ON</div>
                                <div class="fw-bold text-white fs-6">Google Play</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Premium High-Fidelity Feature Trust Cards -->
            <div class="row g-4 mt-5">
                <!-- Delivery Feature Card -->
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="glass-card p-4 d-flex align-items-center gap-4 h-100" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.06); transition: all 0.4s ease;">
                        <div class="d-inline-flex align-items-center justify-content-center bg-orange bg-opacity-10 rounded-4 border border-orange border-opacity-25" style="width: 60px; height: 60px; box-shadow: 0 0 15px rgba(255, 122, 0, 0.1);">
                            <i class="fa-solid fa-clock text-orange fs-3 animate-pulse"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="text-orange fw-bold tracking-widest" style="font-size:0.6rem; letter-spacing: 2px;">SUPER FAST</span>
                                <div class="pulse-dot-green"></div>
                            </div>
                            <h6 class="text-white mb-0 font-poppins fw-bold" style="font-size: 0.95rem;">DELIVERY IN 30 MINS</h6>
                            <p class="text-muted mb-0 mt-1" style="font-size: 0.75rem; line-height: 1.3;">Lightning dispatch from kitchen directly to your doorstep.</p>
                        </div>
                    </div>
                </div>

                <!-- Fresh Ingredients Card -->
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="glass-card p-4 d-flex align-items-center gap-4 h-100" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.06); transition: all 0.4s ease;">
                        <div class="d-inline-flex align-items-center justify-content-center bg-success bg-opacity-10 rounded-4 border border-success border-opacity-25" style="width: 60px; height: 60px; box-shadow: 0 0 15px rgba(0, 230, 118, 0.1);">
                            <i class="fa-solid fa-leaf text-success fs-3 animate-pulse"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="mb-1">
                                <span class="text-success fw-bold tracking-widest" style="font-size:0.6rem; letter-spacing: 2px;">ALWAYS FRESH</span>
                            </div>
                            <h6 class="text-white mb-0 font-poppins fw-bold" style="font-size: 0.95rem;">QUALITY INGREDIENTS</h6>
                            <p class="text-muted mb-0 mt-1" style="font-size: 0.75rem; line-height: 1.3;">100% organic, locally sourced premium gourmet items.</p>
                        </div>
                    </div>
                </div>

                <!-- 24/7 Support Card -->
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="glass-card p-4 d-flex align-items-center gap-4 h-100" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.06); transition: all 0.4s ease;">
                        <div class="d-inline-flex align-items-center justify-content-center bg-info bg-opacity-10 rounded-4 border border-info border-opacity-25" style="width: 60px; height: 60px; box-shadow: 0 0 15px rgba(0, 184, 212, 0.1);">
                            <i class="fa-solid fa-headset text-info fs-3 animate-pulse"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="mb-1">
                                <span class="text-info fw-bold tracking-widest" style="font-size:0.6rem; letter-spacing: 2px;">WE'RE HERE FOR YOU</span>
                            </div>
                            <h6 class="text-white mb-0 font-poppins fw-bold" style="font-size: 0.95rem;">24/7 CUSTOMER SUPPORT</h6>
                            <p class="text-muted mb-0 mt-1" style="font-size: 0.75rem; line-height: 1.3;">Get immediate premium concierge support, any hour.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sleek Glowing Orange Gradient Divider Line -->
            <div class="my-5" style="height: 1px; background: linear-gradient(to right, transparent, rgba(255,122,0,0.2) 50%, transparent);"></div>

            <!-- Absolute Bottom Footer with Copyright and Payments -->
            <!-- Absolute Bottom Footer with Copyright and Payments -->
            <div class="row align-items-center pb-5 pt-3">
                <div class="col-md-4 text-center text-md-start mb-3 mb-md-0">
                    <div class="d-flex align-items-center justify-content-center justify-content-md-start">
                        <i class="fa-solid fa-bolt-lightning text-orange me-2 animate-pulse" style="filter: drop-shadow(0 0 5px var(--accent-orange));"></i>
                        <p class="text-white-50 small mb-0">&copy; 2026 FoodDash Technologies. All rights reserved.</p>
                    </div>
                </div>
                <div class="col-md-5 text-center mb-3 mb-md-0">
                    <div class="d-flex justify-content-center align-items-center gap-3 flex-wrap">
                        <div class="d-inline-flex align-items-center gap-2 px-3 py-1.5 rounded-pill" style="background: rgba(0, 230, 118, 0.05); border: 1px solid rgba(0, 230, 118, 0.15);">
                            <i class="fa-solid fa-shield-halved text-success" style="font-size: 0.75rem;"></i>
                            <span class="text-success fw-bold tracking-widest text-uppercase" style="font-size: 0.55rem; letter-spacing: 1.5px;">SECURE CHECKOUT</span>
                        </div>
                        <div class="payment-suite d-flex align-items-center gap-3">
                            <!-- Premium JazzCash Logo -->
                            <div class="payment-badge-wrapper" title="JazzCash">
                                <svg width="65" height="24" viewBox="0 0 100 36">
                                    <rect width="100" height="36" rx="8" fill="rgba(255,215,0,0.05)" stroke="rgba(255,215,0,0.2)" stroke-width="1"/>
                                    <text x="8" y="24" font-family="Poppins, sans-serif" font-weight="900" font-size="18" fill="#FFD700">Jazz</text>
                                    <text x="52" y="24" font-family="Poppins, sans-serif" font-weight="400" font-size="18" fill="#fff">Cash</text>
                                </svg>
                            </div>
                            <!-- Premium EasyPaisa Logo -->
                            <div class="payment-badge-wrapper" title="EasyPaisa">
                                <svg width="65" height="24" viewBox="0 0 100 36">
                                    <rect width="100" height="36" rx="8" fill="rgba(0,160,90,0.05)" stroke="rgba(0,160,90,0.2)" stroke-width="1"/>
                                    <text x="12" y="24" font-family="Poppins, sans-serif" font-weight="800" font-size="20" fill="#00E676">easy</text>
                                    <text x="58" y="24" font-family="Poppins, sans-serif" font-weight="300" font-size="16" fill="#fff" opacity="0.8">paisa</text>
                                </svg>
                            </div>
                            <div class="d-flex align-items-center gap-2 ms-1 text-white-50">
                                <i class="fa-brands fa-cc-visa fs-4 hover-orange transition-smooth"></i>
                                <i class="fa-brands fa-cc-mastercard fs-4 hover-orange transition-smooth"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 text-center text-md-end">
                    <div class="d-flex justify-content-center justify-content-md-end gap-3 align-items-center">
                        <a href="{{ route('terms') }}" class="footer-legal-link">Terms</a>
                        <a href="{{ route('privacy') }}" class="footer-legal-link">Privacy</a>
                    </div>
                </div>
            </div>

            <style>
                .payment-badge-wrapper {
                    background: rgba(255,255,255,0.02);
                    border: 1px solid rgba(255,255,255,0.06);
                    border-radius: 8px;
                    padding: 1px 1px;
                    transition: all 0.3s ease;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }
                .payment-badge-wrapper:hover {
                    background: rgba(255,255,255,0.08);
                    border-color: rgba(255, 122, 0, 0.4);
                    box-shadow: 0 0 12px rgba(255, 122, 0, 0.2);
                    transform: translateY(-2px);
                }
                .hover-orange:hover {
                    color: var(--accent-orange) !important;
                    filter: drop-shadow(0 0 4px var(--accent-orange));
                }
                .footer-legal-link {
                    color: rgba(255,255,255,0.4);
                    font-size: 0.8rem;
                    font-weight: 500;
                    text-decoration: none;
                    padding: 6px 16px;
                    border-radius: 30px;
                    border: 1px solid transparent;
                    transition: all 0.3s ease;
                }
                .footer-legal-link:hover {
                    color: #FFFFFF !important;
                    background: rgba(255, 122, 0, 0.05);
                    border-color: rgba(255, 122, 0, 0.2);
                    box-shadow: 0 0 10px rgba(255, 122, 0, 0.1);
                }
            </style>

            <style>
                .pulse-dot-green {
                    width: 8px; height: 8px; background: #00E676; border-radius: 50%;
                    box-shadow: 0 0 0 rgba(0, 230, 118, 0.4);
                    animation: pulse-green 2s infinite;
                }
                @keyframes pulse-green {
                    0% { box-shadow: 0 0 0 0 rgba(0, 230, 118, 0.7); }
                    70% { box-shadow: 0 0 0 8px rgba(0, 230, 118, 0); }
                    100% { box-shadow: 0 0 0 0 rgba(0, 230, 118, 0); }
                }
            </style>
        </div>
    </footer>
    @endif

    <!-- Startup-Grade QR Sync Action (FAB) -->
    <div class="qr-sync-pill shadow-premium d-none d-lg-flex" onclick="var m = new bootstrap.Modal(document.getElementById('qrModal')); m.show();">
        <div class="pill-content">
            <div class="icon-stack">
                <i class="fa-solid fa-qrcode text-white"></i>
                <div class="sync-pulse"></div>
            </div>
            <span class="pill-text">Sync App</span>
        </div>
    </div>

    <style>
        .qr-sync-pill {
            position: fixed;
            bottom: 35px; right: 35px;
            background: linear-gradient(135deg, rgba(26, 26, 26, 0.95) 0%, rgba(10, 10, 10, 0.98) 100%);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            width: 52px; height: 52px;
            border-radius: 50px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            cursor: pointer; z-index: 1000;
            display: flex; align-items: center; justify-content: flex-start;
            padding: 7px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0,0,0,0.5), inset 0 1px 2px rgba(255,255,255,0.15);
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        }
        .qr-sync-pill:hover {
            width: 155px;
            border-color: rgba(255, 122, 0, 0.5);
            box-shadow: 0 20px 40px rgba(255, 122, 0, 0.25), inset 0 1px 2px rgba(255,255,255,0.2);
        }
        .pill-content { display: flex; align-items: center; width: 140px; }
        .icon-stack {
            position: relative; display: flex; align-items: center; justify-content: center;
            width: 36px; height: 36px; min-width: 36px;
            background: linear-gradient(135deg, var(--accent-orange), #FF4500);
            border-radius: 50%;
            box-shadow: 0 4px 12px rgba(255, 122, 0, 0.3);
            transition: transform 0.4s ease;
        }
        .qr-sync-pill:hover .icon-stack {
            transform: rotate(90deg);
        }
        .sync-pulse {
            position: absolute; width: 100%; height: 100%;
            background: var(--accent-orange); border-radius: 50%;
            opacity: 0.4; animation: ping 2s infinite;
        }
        @keyframes ping {
            75%, 100% { transform: scale(2); opacity: 0; }
        }
        .pill-text {
            color: #FFFFFF; font-weight: 700; font-size: 0.75rem;
            text-transform: uppercase; letter-spacing: 1.5px;
            font-family: 'Poppins', sans-serif;
            margin-left: 12px;
            opacity: 0;
            transform: translateX(-10px);
            transition: opacity 0.3s ease, transform 0.3s ease;
            white-space: nowrap;
        }
        .qr-sync-pill:hover .pill-text {
            opacity: 1;
            transform: translateX(0);
            transition-delay: 0.1s;
        }
    </style>

    <!-- Premium QR Sync Portal -->
    <div class="modal fade" id="qrModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark-deep border-glass glass-card-heavy overflow-hidden shadow-2xl position-relative">
                <!-- Sleek Close Button -->
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-4" data-bs-dismiss="modal" aria-label="Close" style="z-index: 10; opacity: 0.6; transition: 0.3s;"></button>
                
                <div class="modal-body p-0">
                    <div class="qr-portal-header p-5 text-center position-relative">
                        <div class="portal-glow"></div>
                        <div class="d-inline-flex align-items-center justify-content-center bg-orange rounded-circle mb-4 shadow-orange" style="width:80px; height:80px; position: relative; z-index: 2;">
                            <i class="fa-solid fa-tower-broadcast text-white fs-2 animate-pulse"></i>
                        </div>
                        <h3 class="font-poppins text-white mb-2 fw-bold position-relative z-2">Sync Your Device</h3>
                        <p class="text-white-50 mb-0 px-4 position-relative z-2">Instantly transfer your current session to the mobile app for a seamless handoff.</p>
                    </div>
                    
                    <!-- Sleek Square QR Scanner Area with Target Corners -->
                    <div class="qr-scanner-wrapper mx-auto mb-5 position-relative" style="width: 260px; height: 260px;">
                        <div class="scanner-corner top-left"></div>
                        <div class="scanner-corner top-right"></div>
                        <div class="scanner-corner bottom-left"></div>
                        <div class="scanner-corner bottom-right"></div>
                        
                        <div class="bg-white p-3 rounded-4 d-flex align-items-center justify-content-center shadow-lg position-relative overflow-hidden w-100 h-100">
                            <div class="qr-scanner-line"></div>
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data={{ urlencode(url()->current()) }}&color=000&bgcolor=fff&margin=10" width="220" height="220" alt="Sync QR" class="position-relative z-2">
                        </div>
                    </div>

                    <div class="modal-footer border-0 justify-content-center pb-5 pt-0">
                        <!-- Custom styled glassmorphic security pill (fixes Bootstrap bg-opacity solid white bug) -->
                        <div class="d-flex align-items-center gap-3 py-2 px-4 rounded-pill" style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1);">
                            <i class="fa-solid fa-shield-halved text-success small"></i>
                            <span class="text-white-50 small fw-bold tracking-widest text-uppercase" style="font-size: 0.6rem;">Encrypted Peer-to-Peer Handoff</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .bg-dark-deep { background: #050505 !important; }
        .glass-card-heavy { background: rgba(10,10,10,0.95); backdrop-filter: blur(40px); }
        .portal-glow { position: absolute; top: -50%; left: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(255,122,0,0.08) 0%, transparent 70%); z-index: 1; }
        .shadow-orange { box-shadow: 0 0 30px rgba(255,122,0,0.4); }
        
        /* Premium Scanner Corner Targets */
        .scanner-corner {
            position: absolute; width: 20px; height: 20px;
            border: 3px solid var(--accent-orange); z-index: 4;
            transition: 0.3s;
        }
        .top-left { top: -8px; left: -8px; border-right: none; border-bottom: none; border-radius: 6px 0 0 0; }
        .top-right { top: -8px; right: -8px; border-left: none; border-bottom: none; border-radius: 0 6px 0 0; }
        .bottom-left { bottom: -8px; left: -8px; border-right: none; border-top: none; border-radius: 0 0 0 6px; }
        .bottom-right { bottom: -8px; right: -8px; border-left: none; border-top: none; border-radius: 0 0 6px 0; }
        
        .qr-scanner-wrapper:hover .scanner-corner {
            transform: scale(1.05);
            border-color: var(--accent-orange-light);
            filter: drop-shadow(0 0 8px var(--accent-orange));
        }

        /* Glowing Laser Line */
        .qr-scanner-line {
            position: absolute; top: 0; left: 0; width: 100%; height: 3px;
            background: linear-gradient(to right, transparent, var(--accent-orange), transparent);
            box-shadow: 0 0 10px var(--accent-orange), 0 0 20px var(--accent-orange);
            animation: scan-vertical 3s ease-in-out infinite; z-index: 3;
        }
        @keyframes scan-vertical { 0%, 100% { top: 0; } 50% { top: 100%; } }
        .animate-pulse { animation: pulse-broadcast 2s infinite; }
        @keyframes pulse-broadcast { 0%, 100% { transform: scale(1); opacity: 1; } 50% { transform: scale(1.1); opacity: 0.8; } }
    </style>

    <!-- Search Overlay Modal -->
    <div class="modal fade animate__animated animate__fadeIn" id="searchModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content bg-dark-deep border-0" style="background: rgba(10,10,10,0.98); backdrop-filter: blur(30px);">
                <div class="container py-5 mt-5">
                    <div class="d-flex justify-content-between align-items-center mb-5">
                        <h2 class="text-white font-poppins fw-bold mb-0">Search <span class="text-orange">Everything</span></h2>
                        <button type="button" class="btn-close btn-close-white fs-4" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    
                    <div class="search-input-group position-relative mb-5">
                        <form action="{{ route('restaurants.index') }}" method="GET" id="modalSearchForm">
                            <input type="text" name="search" id="modalSearchInput" class="form-control form-control-lg bg-transparent border-0 border-bottom border-secondary border-opacity-25 rounded-0 text-white fs-1 py-4 px-0 fw-light" placeholder="Type dish, restaurant or cuisine..." autofocus autocomplete="off">
                            <button type="submit" class="position-absolute end-0 top-50 translate-middle-y btn btn-premium rounded-pill px-5 py-3 shadow-lg">
                                Search Now <i class="fa-solid fa-arrow-right ms-2"></i>
                            </button>
                        </form>
                    </div>
 
                    <div class="row mt-5">
                        <div class="col-lg-4 mb-4">
                            <h5 class="text-secondary small fw-bold tracking-widest text-uppercase mb-4">Trending Searches</h5>
                            <div class="d-flex flex-wrap gap-2">
                                <a href="javascript:void(0)" onclick="var inp = document.getElementById('modalSearchInput'); inp.value='Burger'; inp.classList.add('text-orange'); setTimeout(function(){ document.getElementById('modalSearchForm').submit(); }, 150);" class="badge bg-glass border-glass px-4 py-3 rounded-pill text-white text-decoration-none hover-orange transition-smooth">Juicy Burgers</a>
                                <a href="javascript:void(0)" onclick="var inp = document.getElementById('modalSearchInput'); inp.value='Pizza'; inp.classList.add('text-orange'); setTimeout(function(){ document.getElementById('modalSearchForm').submit(); }, 150);" class="badge bg-glass border-glass px-4 py-3 rounded-pill text-white text-decoration-none hover-orange transition-smooth">Italian Pizza</a>
                                <a href="javascript:void(0)" onclick="var inp = document.getElementById('modalSearchInput'); inp.value='Traditional'; inp.classList.add('text-orange'); setTimeout(function(){ document.getElementById('modalSearchForm').submit(); }, 150);" class="badge bg-glass border-glass px-4 py-3 rounded-pill text-white text-decoration-none hover-orange transition-smooth">Traditional Desi</a>
                            </div>
                        </div>
                        <div class="col-lg-4 mb-4">
                            <h5 class="text-secondary small fw-bold tracking-widest text-uppercase mb-4">Quick Links</h5>
                            <div class="d-flex flex-column gap-3">
                                <a href="{{ route('offers') }}" class="text-white text-decoration-none fs-5 hover-orange transition-smooth"><i class="fa-solid fa-tag text-orange me-3"></i> Special Offers</a>
                                <a href="{{ route('restaurants.index', ['rating' => '4.5']) }}" class="text-white text-decoration-none fs-5 hover-orange transition-smooth"><i class="fa-solid fa-compass text-orange me-3"></i> Top Rated Near You</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <style>
        @keyframes scan {
            0% { top: 0; }
            50% { top: 100%; }
            100% { top: 0; }
        }
    </style>

    <!-- Mobile Bottom App Nav (Visible only on mobile) -->
    @if(!isset($hideNavbar) || !$hideNavbar)
    <div class="mobile-nav position-fixed bottom-0 w-100 d-lg-none d-flex justify-content-around">
        <a href="{{ url('/') }}" class="mobile-nav-item {{ request()->is('/') ? 'active' : '' }}">
            <i class="fa-solid fa-house"></i>
            <span>Home</span>
        </a>
        <a href="{{ route('restaurants.index') }}" class="mobile-nav-item {{ request()->is('restaurants*') ? 'active' : '' }}">
            <i class="fa-solid fa-compass"></i>
            <span>Explore</span>
        </a>
        <a href="{{ route('cart.index') }}" class="mobile-nav-item {{ request()->is('cart*') ? 'active' : '' }} position-relative">
            <i class="fa-solid fa-basket-shopping"></i>
            <span>Cart</span>
            @if(($cart_count ?? 0) > 0)
                <span class="position-absolute top-0 end-0 translate-middle bg-danger rounded-circle" style="width:10px; height:10px;"></span>
            @endif
        </a>
        <a href="{{ route('orders.index') }}" class="mobile-nav-item {{ request()->is('orders*') ? 'active' : '' }}">
            <i class="fa-solid fa-receipt"></i>
            <span>Orders</span>
        </a>
        <a href="{{ route('login') }}" class="mobile-nav-item">
            <i class="fa-regular fa-user"></i>
            <span>Profile</span>
        </a>
    </div>
    @endif

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'ease-out-cubic',
            once: true,
            offset: 50
        });

        // Navbar Scroll Effect (guard for pages where navbar is hidden)
        window.addEventListener('scroll', function() {
            const nav = document.getElementById('mainNav');
            if (!nav) return;

            if (window.scrollY > 50) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }
        });

        // Initialize Tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>
    @yield('scripts')
</body>
</html>
