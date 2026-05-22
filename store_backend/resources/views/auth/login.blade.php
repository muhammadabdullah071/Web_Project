@extends('layouts.app', ['hideNavbar' => true, 'hideFooter' => true])

@section('title', 'Sign In - FoodDash Premium')

@section('styles')
<style>
    .auth-container {
        min-height: 100vh;
        display: flex;
    }
    
    .auth-visual {
        flex: 1.2;
        position: relative;
        overflow: hidden;
        display: none;
    }
    @media (min-width: 992px) {
        .auth-visual { display: block; }
    }
    .auth-visual img {
        width: 100%; height: 100%; object-fit: cover;
    }
    .auth-visual::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(0deg, var(--bg-dark-1) 0%, rgba(15,15,15,0.2) 100%);
    }
    .visual-content {
        position: absolute;
        bottom: 10%; left: 10%;
        z-index: 10;
        max-width: 80%;
    }
    
    .auth-form-wrapper {
        flex: 1;
        background: var(--bg-dark-1);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 40px;
        position: relative;
    }
    
    .auth-box {
        width: 100%;
        max-width: 440px;
    }
    
    .form-control-glass {
        background: rgba(255,255,255,0.03);
        border: 1px solid rgba(255,255,255,0.1);
        color: white;
        padding: 14px 20px;
        border-radius: 15px;
        transition: var(--transition-smooth);
        font-size: 1rem;
    }
    .form-control-glass:focus {
        background: rgba(255,255,255,0.05);
        border-color: var(--accent-orange);
        box-shadow: 0 0 20px rgba(255, 122, 0, 0.15);
        color: white;
    }
    .form-control-glass::placeholder { color: rgba(255,255,255,0.3); }
    
    .input-group-text-glass {
        background: rgba(255,255,255,0.03);
        border: 1px solid rgba(255,255,255,0.1);
        border-right: none;
        color: var(--text-muted);
        border-radius: 15px 0 0 15px;
    }
    .form-control-glass.with-icon { border-left: none; border-radius: 0 15px 15px 0; }
    
    .social-btn {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        color: white;
        border-radius: 15px;
        padding: 12px;
        display: flex; align-items: center; justify-content: center; gap: 10px;
        transition: var(--transition-smooth);
        width: 100%;
    }
    .social-btn:hover {
        background: rgba(255,255,255,0.1);
        transform: translateY(-2px);
    }
</style>
@endsection

@section('content')
<div class="auth-container">
    
    <!-- Cinematic Visual Side -->
    <div class="auth-visual">
        <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=2000" alt="Premium Food">
        <div class="visual-content animate__animated animate__fadeInUp">
            <div class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill mb-4" style="background: rgba(255,255,255,0.1); backdrop-filter:blur(10px); border: 1px solid rgba(255,255,255,0.2);">
                <i class="fa-solid fa-star text-warning"></i>
                <span class="text-white fw-bold small tracking-wider">PREMIUM PARTNERS ONLY</span>
            </div>
            <h1 class="font-poppins display-4 text-white mb-3">Taste the <br><span class="text-gradient-orange">Extraordinary.</span></h1>
            <p class="text-secondary fs-5" style="max-width: 400px;">Log in to access exclusive menus, real-time tracking, and priority delivery from the city's finest restaurants.</p>
        </div>
    </div>
    
    <!-- Premium Form Side -->
    <div class="auth-form-wrapper">
        <a href="{{ url('/') }}" class="position-absolute top-0 start-0 m-4 d-flex align-items-center gap-2 text-decoration-none">
            <i class="fa-solid fa-arrow-left text-orange"></i> <span class="text-secondary hover-orange">Back to Home</span>
        </a>
        
        <div class="auth-box">
            <div class="text-center mb-5 animate__animated animate__fadeInDown">
                <a href="{{ url('/') }}" class="font-poppins fs-2 text-white text-decoration-none mb-4 d-inline-block">
                    <i class="fa-solid fa-bolt text-orange"></i> Food<span class="text-orange">Dash</span>
                </a>
                <h3 class="font-poppins fw-bold text-white mt-3">Welcome Back</h3>
                <p class="text-secondary">Enter your credentials to access your account.</p>
            </div>

            @if($errors->any())
            <div class="alert bg-danger bg-opacity-25 border border-danger text-white rounded-3 small mb-4 animate__animated animate__shakeX">
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="animate__animated animate__fadeInUp">
                @csrf
                
                <div class="mb-4">
                    <label class="form-label text-secondary small fw-bold tracking-wider text-uppercase">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text input-group-text-glass"><i class="fa-regular fa-envelope"></i></span>
                        <input type="email" name="email" class="form-control form-control-glass with-icon @error('email') is-invalid @enderror" placeholder="hello@example.com" value="{{ old('email') }}" required autofocus>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <label class="form-label text-secondary small fw-bold tracking-wider text-uppercase mb-0">Password</label>
                        <a href="{{ route('help') }}" class="text-orange small text-decoration-none hover-orange">Forgot Password?</a>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text input-group-text-glass"><i class="fa-solid fa-lock"></i></span>
                        <input type="password" name="password" class="form-control form-control-glass with-icon @error('password') is-invalid @enderror" placeholder="••••••••" required>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-5">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember" style="background-color: transparent; border-color: rgba(255,255,255,0.3);">
                        <label class="form-check-label text-secondary small" for="remember">Remember me</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-premium w-100 py-3 mb-4 fs-5 shadow-lg">
                    Sign In
                </button>

                <div class="position-relative mb-4 text-center">
                    <hr class="border-secondary opacity-25">
                    <span class="position-absolute top-50 start-50 translate-middle bg-dark px-3 text-secondary small" style="background-color: var(--bg-dark-1) !important;">OR SIGN IN WITH</span>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-6">
                        <button type="button" class="social-btn">
                            <img src="https://cdn-icons-png.flaticon.com/512/2991/2991148.png" width="18" alt="Google"> Google
                        </button>
                    </div>
                    <div class="col-6">
                        <button type="button" class="social-btn">
                            <i class="fa-brands fa-apple fs-5"></i> Apple
                        </button>
                    </div>
                </div>

                <p class="text-center text-secondary mt-5">
                    Don't have an account? <a href="{{ route('register') }}" class="text-orange fw-bold text-decoration-none">Create Account</a>
                </p>
            </form>
        </div>
    </div>
</div>
@endsection
