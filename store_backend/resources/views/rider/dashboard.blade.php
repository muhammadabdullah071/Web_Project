@extends('layouts.app')

@section('title', 'Dispatch Hub - Rider')

@section('content')
<div class="container-fluid py-5" style="background: #0A0A0A; min-height: 100vh;">
    <div class="row px-lg-4">
        <!-- Sidebar (Shared logic in dashboard-sidebar class) -->
        <div class="col-lg-2 d-none d-lg-block">
            <div class="dashboard-sidebar shadow-lg p-4 h-100 position-sticky" style="top: 100px; background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05); border-radius: 24px;">
                <h5 class="font-poppins mb-4 text-white">Dispatch Hub</h5>
                <nav class="nav flex-column gap-3">
                    <a href="#" class="nav-link text-orange active d-flex align-items-center gap-2"><i class="fa-solid fa-satellite-dish"></i> Active Tasks</a>
                    <a href="#" class="nav-link text-secondary hover-orange d-flex align-items-center gap-2"><i class="fa-solid fa-clock-rotate-left"></i> Job History</a>
                    <a href="#" class="nav-link text-secondary hover-orange d-flex align-items-center gap-2"><i class="fa-solid fa-wallet"></i> Earnings</a>
                    <a href="#" class="nav-link text-secondary hover-orange d-flex align-items-center gap-2"><i class="fa-solid fa-gear"></i> Vehicle Settings</a>
                </nav>

                <div class="mt-auto pt-5">
                    <div class="bg-success bg-opacity-10 rounded-4 p-3 border border-success border-opacity-20 text-center">
                        <div class="pulse-dot-green mx-auto mb-2"></div>
                        <span class="text-success small fw-bold">ONLINE</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-10">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-5" data-aos="fade-down">
                <div>
                    <h2 class="font-poppins text-white fw-bold mb-1">Rider <span class="text-orange">Command</span></h2>
                    <p class="text-secondary small">Welcome back, <strong>{{ Auth::user()->name }}</strong>. 3 pending deliveries in your zone.</p>
                </div>
                <div class="d-flex gap-3">
                    <div class="glass-card px-4 py-2 d-flex align-items-center gap-3">
                        <i class="fa-solid fa-gas-pump text-orange"></i>
                        <span class="text-white fw-bold">85% Fuel</span>
                    </div>
                    <div class="glass-card px-4 py-2 d-flex align-items-center gap-3">
                        <i class="fa-solid fa-star text-warning"></i>
                        <span class="text-white fw-bold">4.9 Rating</span>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <!-- Map View -->
                <div class="col-lg-8" data-aos="fade-up">
                    <div class="glass-card p-0 overflow-hidden position-relative" style="height: 500px; border-radius: 30px;">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d106234.34110368143!2d72.99042578500206!3d33.69345260193183!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x38dfbfd07891722f%3A0x6059515c3bdb02b6!2sIslamabad%2C%20Islamabad%20Capital%20Territory%2C%20Pakistan!5e0!3m2!1sen!2sus!4v1715858000000!5m2!1sen!2sus" width="100%" height="100%" style="border:0; filter: invert(100%) hue-rotate(180deg) contrast(90%);" allowfullscreen="" loading="lazy"></iframe>
                        
                        <!-- Overlay Legend -->
                        <div class="position-absolute top-0 end-0 m-4">
                            <div class="glass-card p-3 shadow-lg">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <span class="rounded-circle" style="width:10px; height:10px; background:#FF7A00;"></span>
                                    <small class="text-white">Active Order</small>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="rounded-circle" style="width:10px; height:10px; background:#00E676;"></span>
                                    <small class="text-white">Your Location</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Current Order -->
                <div class="col-lg-4" data-aos="fade-left">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 mb-3" role="alert" style="background: rgba(34,197,94,0.1); color: #22c55e;">
                            {{ session('success') }}
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($activeAssignment)
                        <div class="glass-card p-4 border-orange h-100" style="border-width: 1px;">
                            <span class="badge bg-orange text-white px-3 py-2 rounded-pill mb-4 animate-pulse">ACTIVE JOB</span>
                            <h4 class="font-poppins text-white mb-2">Order #{{ $activeAssignment->order->order_number }}</h4>
                            <p class="text-secondary small mb-4"><i class="fa-solid fa-clock me-2"></i>Status: <strong class="text-orange" style="text-transform:uppercase;">{{ $activeAssignment->status }}</strong></p>
                            
                            <div class="pickup-card bg-white bg-opacity-5 rounded-4 p-3 mb-3 border border-white border-opacity-5">
                                <div class="text-orange small fw-bold mb-1">PICKUP AT</div>
                                <h6 class="text-white mb-1">{{ $activeAssignment->order->restaurant->name ?? 'Restaurant' }}</h6>
                                <p class="text-secondary small mb-0">{{ $activeAssignment->order->restaurant->address ?? 'Address' }}</p>
                            </div>

                            <div class="drop-card bg-white bg-opacity-5 rounded-4 p-3 mb-4 border border-white border-opacity-5">
                                <div class="text-success small fw-bold mb-1">DELIVER TO</div>
                                <h6 class="text-white mb-1">{{ $activeAssignment->order->first_name }} {{ $activeAssignment->order->last_name }}</h6>
                                <p class="text-secondary small mb-0">{{ $activeAssignment->order->address }}, {{ $activeAssignment->order->city }}</p>
                            </div>

                            <div class="d-grid gap-2">
                                @if($activeAssignment->status === 'assigned')
                                    <form action="{{ route('rider.status', $activeAssignment->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="picked_up">
                                        <button type="submit" class="btn btn-premium w-100 py-3 rounded-pill fw-bold">MARK AS PICKED UP</button>
                                    </form>
                                @elseif($activeAssignment->status === 'picked_up')
                                    <form action="{{ route('rider.status', $activeAssignment->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="delivered">
                                        <button type="submit" class="btn btn-success w-100 py-3 rounded-pill fw-bold text-white" style="background: linear-gradient(135deg, #22c55e, #15803d); border: none;">MARK AS DELIVERED</button>
                                    </form>
                                @endif
                                <a href="https://maps.google.com/?q={{ urlencode(($activeAssignment->order->address ?? '') . ', ' . ($activeAssignment->order->city ?? '')) }}" target="_blank" class="btn btn-glass-outline w-100 py-3 rounded-pill text-center d-block">VIEW NAVIGATION</a>
                            </div>
                        </div>
                    @else
                        <div class="glass-card p-4 h-100 d-flex flex-column align-items-center justify-content-center text-center py-5" style="border: 1px dashed rgba(255,122,0,0.2);">
                            <div class="mb-4 text-secondary opacity-25">
                                <i class="fa-solid fa-satellite-dish fs-1 animate-pulse" style="color: #FF7A00;"></i>
                            </div>
                            <h5 class="text-white fw-bold">No Active Tasks</h5>
                            <p class="text-secondary small px-3">You're currently in the dispatch queue. Live orders assigned by partners will stream here automatically.</p>
                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-20 px-3 py-2 rounded-pill small fw-bold">
                                Ready for Handoff
                            </span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Earnings & Stats -->
            <div class="row g-4 mt-2">
                <div class="col-md-4" data-aos="fade-up">
                    <div class="glass-card p-4 d-flex align-items-center gap-3">
                        <div class="bg-orange bg-opacity-10 p-3 rounded-circle text-orange">
                            <i class="fa-solid fa-money-bill-wave fs-4"></i>
                        </div>
                        <div>
                            <div class="text-secondary small">Today's Earnings</div>
                            <h4 class="text-white mb-0">PKR 4,250</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="glass-card p-4 d-flex align-items-center gap-3">
                        <div class="bg-success bg-opacity-10 p-3 rounded-circle text-success">
                            <i class="fa-solid fa-route fs-4"></i>
                        </div>
                        <div>
                            <div class="text-secondary small">Distance Traveled</div>
                            <h4 class="text-white mb-0">34.2 KM</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="glass-card p-4 d-flex align-items-center gap-3">
                        <div class="bg-info bg-opacity-10 p-3 rounded-circle text-info">
                            <i class="fa-solid fa-check-double fs-4"></i>
                        </div>
                        <div>
                            <div class="text-secondary small">Completed Jobs</div>
                            <h4 class="text-white mb-0">{{ $completedCount }} Today</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
