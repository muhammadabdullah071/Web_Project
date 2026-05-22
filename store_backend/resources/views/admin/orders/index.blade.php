@extends('layouts.app')
@section('title', 'Live Orders - FoodDash Admin')

@section('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');
* { font-family: 'Inter', sans-serif; }
.admin-wrap { display: flex; min-height: calc(100vh - 76px); background: #060608; }
.admin-sidebar { width: 260px; min-width: 260px; background: #0C0C10; border-right: 1px solid rgba(255,122,0,0.08); padding: 32px 16px; position: sticky; top: 76px; height: calc(100vh - 76px); overflow-y: auto; display: flex; flex-direction: column; }
.admin-sidebar::-webkit-scrollbar { width: 0; }
.sidebar-brand { padding: 0 12px 28px; border-bottom: 1px solid rgba(255,255,255,0.04); margin-bottom: 24px; }
.sidebar-brand h6 { font-size: 0.65rem; letter-spacing: 3px; color: rgba(255,122,0,0.6); text-transform: uppercase; margin-bottom: 4px; }
.sidebar-brand p { font-size: 0.8rem; color: rgba(255,255,255,0.4); margin: 0; }
.sidebar-section-label { font-size: 0.6rem; letter-spacing: 2.5px; color: rgba(255,255,255,0.2); text-transform: uppercase; padding: 0 12px; margin: 20px 0 8px; display: block; }
.s-link { display: flex; align-items: center; gap: 12px; padding: 11px 14px; border-radius: 12px; color: rgba(255,255,255,0.4); text-decoration: none; font-size: 0.875rem; font-weight: 500; transition: all 0.2s ease; margin-bottom: 2px; }
.s-link i { width: 20px; text-align: center; }
.s-link:hover, .s-link.active { background: rgba(255,122,0,0.1); color: #FF7A00; }
.badge-count { margin-left: auto; background: rgba(255,122,0,0.2); color: #FF7A00; font-size: 0.65rem; padding: 2px 8px; border-radius: 20px; font-weight: 700; }
.sidebar-logout { margin-top: auto; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.04); }
.admin-main { flex: 1; padding: 36px 40px; overflow-x: hidden; }

.page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
.page-header h1 { font-size: 1.8rem; font-weight: 800; color: #fff; margin: 0; }
.page-header h1 span { color: #FF7A00; }
.live-badge { display: flex; align-items: center; gap: 7px; background: rgba(34,197,94,0.08); border: 1px solid rgba(34,197,94,0.2); border-radius: 20px; padding: 6px 14px; }
.live-dot { width: 8px; height: 8px; background: #22c55e; border-radius: 50%; animation: lp 2s infinite; }
@keyframes lp { 0%,100%{opacity:1;} 50%{opacity:0.4;} }

.flash-msg { background: rgba(34,197,94,0.08); border: 1px solid rgba(34,197,94,0.2); color: #22c55e; padding: 12px 18px; border-radius: 12px; margin-bottom: 20px; font-size: 0.85rem; font-weight: 600; display: flex; align-items: center; gap: 10px; }

/* Quick filter tabs */
.tab-row { display: flex; gap: 8px; margin-bottom: 20px; flex-wrap: wrap; }
.tab { padding: 7px 16px; border-radius: 20px; font-size: 0.78rem; font-weight: 700; text-decoration: none; border: 1px solid rgba(255,255,255,0.08); color: rgba(255,255,255,0.4); transition: all 0.2s; }
.tab:hover, .tab.active { background: rgba(255,122,0,0.1); border-color: rgba(255,122,0,0.3); color: #FF7A00; }

.data-table-wrap { background: #0C0C10; border: 1px solid rgba(255,255,255,0.05); border-radius: 20px; overflow: hidden; }
.data-table { width: 100%; border-collapse: collapse; }
.data-table thead th { background: rgba(255,255,255,0.02); color: rgba(255,255,255,0.3); font-size: 0.65rem; letter-spacing: 2px; text-transform: uppercase; padding: 16px 20px; border-bottom: 1px solid rgba(255,255,255,0.04); font-weight: 600; }
.data-table tbody td { padding: 15px 20px; border-bottom: 1px solid rgba(255,255,255,0.03); vertical-align: middle; color: rgba(255,255,255,0.8); font-size: 0.875rem; }
.data-table tbody tr:last-child td { border-bottom: none; }
.data-table tbody tr:hover td { background: rgba(255,255,255,0.012); }

.order-id { color: #FF7A00; font-weight: 700; font-size: 0.8rem; font-family: monospace; letter-spacing: 0.5px; }
.cust-name { font-weight: 600; color: #fff; font-size: 0.87rem; }
.cust-email { font-size: 0.73rem; color: rgba(255,255,255,0.3); margin-top: 1px; }
.amount-val { font-weight: 800; color: #FF7A00; }
.time-val { font-size: 0.78rem; color: rgba(255,255,255,0.35); }

.status-pill { display: inline-flex; align-items: center; gap: 5px; padding: 4px 12px; border-radius: 20px; font-size: 0.72rem; font-weight: 700; }
.s-pending   { background: rgba(234,179,8,0.1);  color: #eab308; border: 1px solid rgba(234,179,8,0.25); }
.s-preparing { background: rgba(255,122,0,0.1);  color: #FF7A00; border: 1px solid rgba(255,122,0,0.25); }
.s-transit   { background: rgba(99,102,241,0.1); color: #818cf8; border: 1px solid rgba(99,102,241,0.25); }
.s-delivered { background: rgba(34,197,94,0.1);  color: #22c55e; border: 1px solid rgba(34,197,94,0.25); }
.s-cancelled { background: rgba(239,68,68,0.1);  color: #ef4444; border: 1px solid rgba(239,68,68,0.25); }

.pay-paid    { background: rgba(34,197,94,0.08); color: #22c55e; border: 1px solid rgba(34,197,94,0.2); padding: 3px 10px; border-radius: 20px; font-size: 0.7rem; font-weight: 700; }
.pay-pending { background: rgba(234,179,8,0.08); color: #eab308; border: 1px solid rgba(234,179,8,0.2); padding: 3px 10px; border-radius: 20px; font-size: 0.7rem; font-weight: 700; }

/* Inline status update */
.status-form select { 
    background: #0C0C10; 
    border: 1px solid rgba(255,122,0,0.3); 
    border-radius: 8px; 
    color: #ffffff; 
    padding: 6px 10px; 
    font-size: 0.78rem; 
    outline: none; 
    cursor: pointer; 
    transition: all 0.2s ease;
}
.status-form select:focus { 
    border-color: #FF7A00; 
}
.status-form select option {
    background-color: #0C0C10 !important;
    color: #ffffff !important;
}
.status-form button { background: rgba(255,122,0,0.15); border: 1px solid rgba(255,122,0,0.25); border-radius: 8px; color: #FF7A00; padding: 6px 12px; font-size: 0.75rem; font-weight: 700; cursor: pointer; transition: all 0.2s; margin-left: 6px; }
.status-form button:hover { background: rgba(255,122,0,0.25); }

.view-btn { display: inline-flex; align-items: center; gap: 6px; color: rgba(255,255,255,0.4); font-size: 0.8rem; font-weight: 600; text-decoration: none; padding: 6px 12px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.08); transition: all 0.2s; }
.view-btn:hover { color: #FF7A00; border-color: rgba(255,122,0,0.3); background: rgba(255,122,0,0.05); }

.pagination-wrap { display: flex; justify-content: space-between; align-items: center; padding: 16px 20px; border-top: 1px solid rgba(255,255,255,0.04); }
.page-btn { background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08); color: rgba(255,255,255,0.5); border-radius: 10px; padding: 8px 18px; font-size: 0.8rem; font-weight: 600; text-decoration: none; transition: all 0.2s; }
.page-btn:hover:not(.disabled) { background: rgba(255,122,0,0.1); border-color: rgba(255,122,0,0.3); color: #FF7A00; }
.page-btn.disabled { opacity: 0.3; pointer-events: none; }
.page-info { font-size: 0.78rem; color: rgba(255,255,255,0.3); }
</style>
@endsection

@section('content')
<div class="admin-wrap">

    @include('admin.partials.sidebar')

    <main class="admin-main">

        @if(session('success'))
        <div class="flash-msg"><i class="fa-solid fa-circle-check"></i> {{ session('success') }}</div>
        @endif

        <div class="page-header">
            <h1>{{ auth()->user()->role === 'owner' ? 'Restaurant' : 'Live' }} <span>Orders</span></h1>
            <div class="live-badge">
                <div class="live-dot"></div>
                <span style="font-size:0.75rem;color:rgba(255,255,255,0.5);font-weight:600;">Real-time</span>
            </div>
        </div>

        <div class="data-table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Restaurant</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Payment</th>
                        <th>Update Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="admin-orders-tbody">
                    @forelse($orders as $order)
                    @php
                        $s = strtolower($order->status);
                        $sc = 's-pending'; $si = 'receipt';
                        if(in_array($s,['preparing','processing'])){ $sc='s-preparing'; $si='fire-burner'; }
                        elseif(in_array($s,['out_for_delivery','shipped'])){ $sc='s-transit'; $si='motorcycle'; }
                        elseif(in_array($s,['delivered','completed'])){ $sc='s-delivered'; $si='circle-check'; }
                        elseif($s==='cancelled'){ $sc='s-cancelled'; $si='xmark'; }
                    @endphp
                    <tr>
                        <td><span class="order-id">#{{ $order->order_number }}</span></td>
                        <td>
                            <div class="cust-name">{{ $order->first_name }} {{ $order->last_name }}</div>
                            <div class="cust-email">{{ $order->email }}</div>
                        </td>
                        <td style="color:rgba(255,255,255,0.45);font-size:0.82rem;">{{ $order->restaurant->name ?? '—' }}</td>
                        <td><span class="amount-val">Rs. {{ number_format($order->total, 0) }}</span></td>
                        <td><span class="time-val">{{ $order->created_at->format('M d, h:i A') }}</span></td>
                        <td>
                            @if($order->payment_status === 'paid')
                                <span class="pay-paid"><i class="fa-solid fa-circle-check" style="font-size:0.65rem;"></i> Paid</span>
                            @else
                                <span class="pay-pending"><i class="fa-solid fa-clock" style="font-size:0.65rem;"></i> Pending</span>
                            @endif
                        </td>
                        <td>
                            <form class="status-form" action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" style="display:flex;align-items:center;">
                                @csrf @method('PATCH')
                                <select name="status">
                                    <option value="pending" {{ $order->status=='pending'?'selected':'' }}>Pending</option>
                                    <option value="preparing" {{ in_array($order->status,['preparing','processing'])?'selected':'' }}>Preparing</option>
                                    <option value="ready" {{ $order->status=='ready'?'selected':'' }}>Ready</option>
                                    <option value="out_for_delivery" {{ in_array($order->status,['out_for_delivery','shipped'])?'selected':'' }}>Out for Delivery</option>
                                    <option value="delivered" {{ $order->status=='delivered'?'selected':'' }}>Delivered</option>
                                    <option value="cancelled" {{ $order->status=='cancelled'?'selected':'' }}>Cancelled</option>
                                </select>
                                <button type="submit"><i class="fa-solid fa-check"></i></button>
                            </form>
                        </td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="view-btn">
                                <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" style="text-align:center;padding:60px;color:rgba(255,255,255,0.25);">
                            <i class="fa-solid fa-inbox" style="font-size:2.5rem;display:block;margin-bottom:12px;opacity:0.3;"></i>
                            No orders yet — the platform is ready and waiting.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="pagination-wrap" id="admin-orders-pagination">
                <a href="{{ $orders->previousPageUrl() ?? '#' }}" class="page-btn {{ $orders->onFirstPage() ? 'disabled' : '' }}"><i class="fa-solid fa-chevron-left" style="margin-right:6px;"></i>Previous</a>
                <span class="page-info">{{ $orders->total() }} total orders · Page {{ $orders->currentPage() }} of {{ $orders->lastPage() }}</span>
                <a href="{{ $orders->nextPageUrl() ?? '#' }}" class="page-btn {{ !$orders->hasMorePages() ? 'disabled' : '' }}">Next<i class="fa-solid fa-chevron-right" style="margin-left:6px;"></i></a>
            </div>
        </div>
    </main>
</div>
@endsection

@section('scripts')
<script>
// High-fidelity Auto-refresh for premium real-time live orders list
const liveBadge = document.querySelector('.live-badge');
if (liveBadge) {
    liveBadge.innerHTML = `
        <div class="live-dot" style="background:#22c55e; animation: lp 2s infinite;"></div>
        <span style="font-size:0.75rem;color:rgba(34,197,94,0.8);font-weight:600;" id="sync-status">Live Connected</span>
    `;
}

function performLiveSync() {
    const syncStatus = document.getElementById('sync-status');
    const liveDot = document.querySelector('.live-dot');
    
    if (syncStatus) {
        syncStatus.innerText = 'Syncing...';
        syncStatus.style.color = 'rgba(255,122,0,0.8)';
    }
    if (liveDot) {
        liveDot.style.background = '#FF7A00';
    }

    fetch(window.location.href)
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');

            // 1. Update orders table
            const newTable = doc.getElementById('admin-orders-tbody');
            const currentTable = document.getElementById('admin-orders-tbody');
            if (newTable && currentTable) {
                currentTable.innerHTML = newTable.innerHTML;
            }

            // 2. Update pagination
            const newPagination = doc.getElementById('admin-orders-pagination');
            const currentPagination = document.getElementById('admin-orders-pagination');
            if (newPagination && currentPagination) {
                currentPagination.innerHTML = newPagination.innerHTML;
            }

            // 3. Update pending orders sidebar badge
            const newBadge = doc.querySelector('.badge-count');
            const currentBadge = document.querySelector('.badge-count');
            if (newBadge) {
                if (currentBadge) {
                    currentBadge.innerHTML = newBadge.innerHTML;
                } else {
                    const ordersLink = document.querySelector('a[href*="orders"]');
                    if (ordersLink && !ordersLink.querySelector('.badge-count')) {
                        const span = document.createElement('span');
                        span.className = 'badge-count';
                        span.innerHTML = newBadge.innerHTML;
                        ordersLink.appendChild(span);
                    }
                }
            } else if (currentBadge) {
                currentBadge.remove();
            }

            // Success feedback
            if (syncStatus) {
                syncStatus.innerText = 'Live Sync Active';
                syncStatus.style.color = 'rgba(34,197,94,0.8)';
            }
            if (liveDot) {
                liveDot.style.background = '#22c55e';
            }
        })
        .catch(err => {
            console.error('Sync error:', err);
            if (syncStatus) {
                syncStatus.innerText = 'Sync Offline';
                syncStatus.style.color = 'rgba(239,68,68,0.8)';
            }
            if (liveDot) {
                liveDot.style.background = '#ef4444';
            }
        });
}

// Sync every 5 seconds for ultimate real-time experience
setInterval(performLiveSync, 5000);
</script>
@endsection
