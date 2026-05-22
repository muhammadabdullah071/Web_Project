@extends('layouts.app', ['hideNavbar' => true, 'hideFooter' => true])

@section('title', 'Sign Up - FoodDash Premium')

@section('styles')
<style>
    .auth-container {
        min-height: 100vh;
        display: flex;
        flex-direction: row-reverse;
        background: #0a0a0a;
        overflow: hidden;
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
        animation: kenBurns 20s infinite alternate;
    }
    @keyframes kenBurns {
        from { transform: scale(1) translate(0, 0); }
        to { transform: scale(1.15) translate(-2%, -2%); }
    }
    .auth-visual::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(90deg, var(--bg-dark-1) 0%, rgba(15,15,15,0.1) 100%);
    }
    
    .auth-form-wrapper {
        flex: 1;
        background: linear-gradient(-45deg, #0f0f0f, #1a1a1a, #0a0a0a, #151515);
        background-size: 400% 400%;
        animation: gradientBG 15s ease infinite;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 40px;
        position: relative;
    }
    @keyframes gradientBG {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    
    .auth-box {
        width: 100%;
        max-width: 550px;
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        padding: 60px;
        border-radius: 40px;
        box-shadow: 0 40px 100px rgba(0,0,0,0.5);
    }
    
    .form-control-glass {
        background: rgba(255,255,255,0.02);
        border: 1px solid rgba(255,255,255,0.08);
        color: white;
        padding: 18px 25px;
        border-radius: 20px;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        font-size: 1.1rem;
    }
    .form-control-glass:focus {
        background: rgba(255,255,255,0.05);
        border-color: var(--accent-orange);
        box-shadow: 0 0 30px rgba(255, 122, 0, 0.2);
        transform: translateY(-2px);
        color: white;
    }
    
    .btn-premium {
        background: linear-gradient(135deg, #ff7a00 0%, #ff4d00 100%);
        border: none;
        position: relative;
        overflow: hidden;
        transition: all 0.4s ease;
    }
    .btn-premium::after {
        content: '';
        position: absolute;
        top: -50%; left: -50%;
        width: 200%; height: 200%;
        background: linear-gradient(45deg, transparent, rgba(255,255,255,0.2), transparent);
        transform: rotate(45deg);
        transition: 0.6s;
    }
    .btn-premium:hover::after {
        left: 100%;
    }
    .btn-premium:hover {
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 20px 40px rgba(255, 122, 0, 0.4);
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
    
</style>
@endsection

@section('content')
<div class="auth-container">
    
    <!-- Cinematic Visual Side -->
    <div class="auth-visual">
        <img src="https://images.unsplash.com/photo-1555939594-58d7cb561ad1?q=80&w=2000" alt="Premium Dining">
        <div class="visual-content animate__animated animate__fadeInUp">
            <h1 class="font-poppins display-4 text-white mb-3">Join the <br><span class="text-gradient-orange">Elite Circle.</span></h1>
            <p class="text-secondary fs-5 ms-auto" style="max-width: 400px;">Create an account to unlock personalized recommendations, secret menus, and exclusive partner rewards.</p>
        </div>
    </div>
    
    <!-- Premium Form Side -->
    <div class="auth-form-wrapper">
        <a href="{{ url('/') }}" class="position-absolute top-0 end-0 m-4 d-flex align-items-center gap-2 text-decoration-none">
            <span class="text-secondary hover-orange">Back to Home</span> <i class="fa-solid fa-arrow-right text-orange"></i>
        </a>
        
        <div class="auth-box">
            <div class="text-center mb-5 animate__animated animate__fadeInDown">
                <a href="{{ url('/') }}" class="font-poppins fs-2 text-white text-decoration-none mb-4 d-inline-block hover-scale">
                    <i class="fa-solid fa-bolt text-orange"></i> Food<span class="text-orange">Dash</span>
                </a>
                <h2 class="font-poppins fw-bold text-white mt-2 display-5 tracking-tight">Join the <span class="text-gradient-orange">Elite.</span></h2>
                <p class="text-secondary fs-5 opacity-75">Start your premium food journey today.</p>
            </div>

            @if($errors->any())
            <div class="alert bg-danger bg-opacity-10 border border-danger border-opacity-25 text-white rounded-4 small mb-4 animate__animated animate__shakeX">
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="animate__animated animate__fadeInUp animate__delay-1s">
                @csrf
                
                <div class="mb-4">
                    <label class="form-label text-secondary fw-bold tracking-wider text-uppercase small opacity-50 ms-2">Full Name</label>
                    <div class="input-group">
                        <span class="input-group-text input-group-text-glass" style="border-radius: 20px 0 0 20px;"><i class="fa-regular fa-user"></i></span>
                        <input type="text" name="name" class="form-control form-control-glass with-icon @error('name') is-invalid @enderror" placeholder="Ahmed Ali" value="{{ old('name') }}" required autofocus style="border-radius: 0 20px 20px 0;">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label text-secondary fw-bold tracking-wider text-uppercase small opacity-50 ms-2">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text input-group-text-glass" style="border-radius: 20px 0 0 20px;"><i class="fa-regular fa-envelope"></i></span>
                        <input type="email" name="email" class="form-control form-control-glass with-icon @error('email') is-invalid @enderror" placeholder="hello@example.com" value="{{ old('email') }}" required style="border-radius: 0 20px 20px 0;">
                    </div>
                </div>

                <div class="row g-4 mb-5">
                    <div class="col-md-6">
                        <label class="form-label text-secondary fw-bold tracking-wider text-uppercase small opacity-50 ms-2 mb-1">Password</label>
                        <div class="input-group">
                            <span class="input-group-text input-group-text-glass" style="border-radius: 20px 0 0 20px;"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" name="password" class="form-control form-control-glass with-icon @error('password') is-invalid @enderror" placeholder="••••••••" required style="border-radius: 0 20px 20px 0;">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-secondary fw-bold tracking-wider text-uppercase small opacity-50 ms-2 mb-1">Confirm</label>
                        <div class="input-group">
                            <span class="input-group-text input-group-text-glass" style="border-radius: 20px 0 0 20px;"><i class="fa-solid fa-shield-check"></i></span>
                            <input type="password" name="password_confirmation" class="form-control form-control-glass with-icon" placeholder="••••••••" required style="border-radius: 0 20px 20px 0;">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-premium w-100 py-3 mb-4 fs-4 fw-bold shadow-lg rounded-pill">
                    Create Account
                </button>

                <p class="text-center text-secondary mt-4 fs-5">
                    Already have an account? <a href="{{ route('login') }}" class="text-orange fw-bold text-decoration-none hover-orange">Sign In</a>
                </p>
            </form>
        </div>
    </div>
</div>
@endsection
