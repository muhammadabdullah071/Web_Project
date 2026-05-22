@extends('layouts.app')

@section('title', 'My Orders - Premium E-Commerce')

@section('content')
<div class="container py-5 mt-5">
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h1 class="display-5 fw-bold mb-0 text-white">My Orders</h1>
            <p class="text-white-50 mt-2">View and track your order history</p>
        </div>
        <div class="col-md-6 text-md-end mt-3 mt-md-0">
            <a href="{{ url('/') }}" class="btn btn-glass-outline btn-sm rounded-pill px-4">Continue Shopping</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="glass-card shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            @if($orders->count() > 0)
                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle mb-0 bg-transparent">
                        <thead class="bg-black bg-opacity-50 text-white-50 small text-uppercase tracking-wider">
                            <tr>
                                <th class="ps-4 py-3 font-weight-bold border-0 text-white-50">Order ID</th>
                                <th class="py-3 border-0 text-white-50">Date</th>
                                <th class="py-3 border-0 text-white-50">Total</th>
                                <th class="py-3 border-0 text-white-50">Status</th>
                                <th class="pe-4 py-3 border-0 text-end text-white-50">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                                    <td class="ps-4 py-3">
                                        <span class="fw-bold text-white">#{{ str_pad($order->order_number ?? $order->id, 6, '0', STR_PAD_LEFT) }}</span>
                                    </td>
                                    <td class="py-3 text-white-50">
                                        {{ $order->created_at->format('M d, Y h:i A') }}
                                    </td>
                                    <td class="py-3 fw-bold text-orange">
                                        PKR {{ number_format($order->total, 0) }}
                                    </td>
                                    <td class="py-3">
                                        @if($order->status == 'pending')
                                            <span class="badge bg-warning text-dark rounded-pill px-3 py-2"><i class="fa-regular fa-clock me-1"></i> Pending</span>
                                        @elseif($order->status == 'processing')
                                            <span class="badge bg-info rounded-pill px-3 py-2"><i class="fa-solid fa-spinner fa-spin me-1"></i> Processing</span>
                                        @elseif($order->status == 'completed' || $order->status == 'delivered')
                                            <span class="badge bg-success rounded-pill px-3 py-2"><i class="fa-solid fa-check-double me-1"></i> Completed</span>
                                        @elseif($order->status == 'cancelled')
                                            <span class="badge bg-danger rounded-pill px-3 py-2"><i class="fa-solid fa-xmark me-1"></i> Cancelled</span>
                                        @else
                                            <span class="badge bg-secondary rounded-pill px-3 py-2">{{ ucfirst($order->status) }}</span>
                                        @endif
                                    </td>
                                    <td class="pe-4 py-3 text-end">
                                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-outline-light rounded-pill px-3 shadow-sm hover-orange">
                                            View Details
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fa-solid fa-box-open text-white-50 opacity-25" style="font-size: 5rem;"></i>
                    </div>
                    <h4 class="fw-bold text-white">No orders yet</h4>
                    <p class="text-white-50 mb-4">Looks like you haven't made your order yet.</p>
                    <a href="{{ route('home') }}" class="btn btn-orange rounded-pill px-4 py-2">Start Shopping</a>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .hover-dark:hover {
        background-color: #212529;
        color: white;
        border-color: #212529;
    }
</style>
@endsection
