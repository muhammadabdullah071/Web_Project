@extends('layouts.app')

@section('title', 'Help Center - FoodDash Support')

@section('content')
<div class="container py-5 mt-5">
    <div class="text-center mb-5" data-aos="fade-down">
        <h1 class="display-4 font-poppins fw-bold text-white mb-3">How can we <span class="text-orange">help you?</span></h1>
        <p class="text-secondary fs-5">Everything you need to know about your premium food journey.</p>
    </div>

    <!-- Search Help -->
    <div class="row justify-content-center mb-5" data-aos="fade-up">
        <div class="col-lg-8">
            <div class="glass-card p-2 d-flex align-items-center gap-3">
                <i class="fa-solid fa-magnifying-glass text-orange ms-3 fs-4"></i>
                <input type="text" class="form-control bg-transparent border-0 text-white p-3 shadow-none" placeholder="Search for questions (e.g. 'refund', 'tracking', 'partner')">
                <button class="btn btn-premium rounded-pill px-4 me-1">Search</button>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
            <div class="glass-card p-4 h-100 text-center hover-up">
                <div class="rounded-circle bg-glass p-4 d-inline-block mb-4 text-orange">
                    <i class="fa-solid fa-clock-rotate-left fs-1"></i>
                </div>
                <h4 class="font-poppins mb-3">Order Tracking</h4>
                <p class="text-secondary small">Learn how to track your order in real-time and communicate with your rider.</p>
                <a href="#" class="text-orange text-decoration-none small fw-bold">Learn More <i class="fa-solid fa-arrow-right ms-1"></i></a>
            </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
            <div class="glass-card p-4 h-100 text-center hover-up">
                <div class="rounded-circle bg-glass p-4 d-inline-block mb-4 text-orange">
                    <i class="fa-solid fa-wallet fs-1"></i>
                </div>
                <h4 class="font-poppins mb-3">Payments & Refunds</h4>
                <p class="text-secondary small">Details on JazzCash, EasyPaisa, and our 100% refund guarantee policy.</p>
                <a href="#" class="text-orange text-decoration-none small fw-bold">Learn More <i class="fa-solid fa-arrow-right ms-1"></i></a>
            </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
            <div class="glass-card p-4 h-100 text-center hover-up">
                <div class="rounded-circle bg-glass p-4 d-inline-block mb-4 text-orange">
                    <i class="fa-solid fa-store fs-1"></i>
                </div>
                <h4 class="font-poppins mb-3">Become a Partner</h4>
                <p class="text-secondary small">Reach thousands of customers by listing your restaurant on our premium platform.</p>
                <a href="#" class="text-orange text-decoration-none small fw-bold">Join Us <i class="fa-solid fa-arrow-right ms-1"></i></a>
            </div>
        </div>
    </div>

    <div class="glass-card p-5 mb-5" data-aos="fade-up">
        <h3 class="font-poppins mb-4">Frequently Asked Questions</h3>
        <div class="accordion accordion-flush" id="faqAccordion">
            <div class="accordion-item bg-transparent border-bottom border-secondary border-opacity-25">
                <h2 class="accordion-header">
                    <button class="accordion-button bg-transparent text-white collapsed shadow-none py-4" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                        How long does the premium delivery take?
                    </button>
                </h2>
                <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body text-secondary pb-4">
                        Our average delivery time in Islamabad is 25-35 minutes. We use high-speed thermal bags to ensure your food arrives at the perfect temperature.
                    </div>
                </div>
            </div>
            <div class="accordion-item bg-transparent border-bottom border-secondary border-opacity-25">
                <h2 class="accordion-header">
                    <button class="accordion-button bg-transparent text-white collapsed shadow-none py-4" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                        Do you support JazzCash and EasyPaisa?
                    </button>
                </h2>
                <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body text-secondary pb-4">
                        Yes, we fully support local mobile wallets including JazzCash and EasyPaisa, alongside all major credit/debit cards.
                    </div>
                </div>
            </div>
            <div class="accordion-item bg-transparent border-bottom border-secondary border-opacity-25">
                <h2 class="accordion-header">
                    <button class="accordion-button bg-transparent text-white collapsed shadow-none py-4" type="button" data-bs-target="#faq3">
                        What is the platform fee?
                    </button>
                </h2>
                <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body text-secondary pb-4">
                        We charge a flat 500 PKR platform fee to maintain our high-end delivery infrastructure and ensure 100% reliability for every order.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Support -->
    <div class="glass-card p-5 text-center bg-orange-gradient-soft" data-aos="zoom-in">
        <h3 class="font-poppins mb-3">Still need help?</h3>
        <p class="text-secondary mb-4">Our support team is available 24/7 to assist you.</p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="mailto:support@fooddash.com" class="btn btn-premium rounded-pill px-5">Email Support</a>
            <a href="#" class="btn btn-glass-outline rounded-pill px-5">Live Chat</a>
        </div>
    </div>
</div>

<style>
    .bg-orange-gradient-soft {
        background: radial-gradient(circle at top right, rgba(255, 122, 0, 0.05), transparent);
    }
    .hover-up:hover {
        transform: translateY(-10px);
        background: rgba(255, 255, 255, 0.05);
    }
    .accordion-button::after {
        filter: invert(1);
    }
    .accordion-button:not(.collapsed) {
        color: var(--accent-orange);
    }
</style>
@endsection
