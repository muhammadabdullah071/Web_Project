@extends('layouts.app')
@section('title', 'Order #{{ $order->order_number }} - FoodDash Admin')

@section('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
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
.sidebar-logout { margin-top: auto; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.04); }
.admin-main { flex: 1; padding: 36px 40px; overflow-x: hidden; }

.back-btn { display: inline-flex; align-items: center; gap: 8px; color: rgba(255,255,255,0.4); text-decoration: none; font-size: 0.82rem; font-weight: 600; margin-bottom: 28px; transition: color 0.2s; }
.back-btn:hover { color: #FF7A00; }

.order-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 28px; }
.order-header h1 { font-size: 1.7rem; font-weight: 800; color: #fff; margin: 0 0 6px; }
.order-header h1 span { color: #FF7A00; font-family: monospace; }
.order-date { font-size: 0.8rem; color: rgba(255,255,255,0.3); }

.detail-grid { display: grid; grid-template-columns: 1fr 320px; gap: 20px; align-items: start; }

.detail-card { background: #0C0C10; border: 1px solid rgba(255,255,255,0.05); border-radius: 20px; padding: 26px; margin-bottom: 16px; }
.detail-card h5 { font-size: 0.68rem; letter-spacing: 2.5px; text-transform: uppercase; color: rgba(255,122,0,0.7); margin: 0 0 20px; padding-bottom: 12px; border-bottom: 1px solid rgba(255,255,255,0.04); }

/* Items table */
.items-table { width: 100%; border-collapse: collapse; }
.items-table thead th { color: rgba(255,255,255,0.3); font-size: 0.65rem; letter-spacing: 1.5px; text-transform: uppercase; padding: 0 0 12px; border-bottom: 1px solid rgba(255,255,255,0.05); font-weight: 600; }
.items-table thead th:last-child { text-align: right; }
.items-table tbody td { padding: 14px 0; border-bottom: 1px solid rgba(255,255,255,0.03); font-size: 0.88rem; color: rgba(255,255,255,0.8); vertical-align: middle; }
.items-table tbody tr:last-child td { border-bottom: none; }
.items-table tfoot td { padding: 12px 0; font-size: 0.85rem; color: rgba(255,255,255,0.4); }
.items-table tfoot tr.total-row td { font-size: 1.05rem; font-weight: 800; color: #FF7A00; padding-top: 16px; border-top: 1px solid rgba(255,255,255,0.06); }
.item-qty-badge { display: inline-block; background: rgba(255,122,0,0.1); color: #FF7A00; border-radius: 6px; padding: 2px 8px; font-size: 0.75rem; font-weight: 700; margin-right: 8px; }

/* Info rows */
.info-row { display: flex; justify-content: space-between; align-items: center; padding: 12px 0; border-bottom: 1px solid rgba(255,255,255,0.04); }
.info-row:last-child { border-bottom: none; }
.info-label { font-size: 0.78rem; color: rgba(255,255,255,0.35); font-weight: 500; }
.info-val { font-size: 0.85rem; color: rgba(255,255,255,0.8); font-weight: 600; text-align: right; }

/* Status update */
.status-select { width: 100%; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 12px 16px; color: #fff; font-size: 0.9rem; outline: none; margin-bottom: 12px; cursor: pointer; }
.status-select:focus { border-color: rgba(255,122,0,0.5); }
.status-select option { background: #111; }
.btn-update { background: linear-gradient(135deg,#FF7A00,#FF4500); border: none; border-radius: 12px; padding: 12px 20px; color: #fff; font-size: 0.88rem; font-weight: 700; cursor: pointer; transition: all 0.2s; width: 100%; }
.btn-update:hover { transform: translateY(-1px); box-shadow: 0 8px 20px rgba(255,122,0,0.3); }

.flash-msg { background: rgba(34,197,94,0.08); border: 1px solid rgba(34,197,94,0.2); color: #22c55e; padding: 12px 18px; border-radius: 12px; margin-bottom: 20px; font-size: 0.85rem; font-weight: 600; display: flex; align-items: center; gap: 10px; }

/* Status badges */
.status-pill { display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px; border-radius: 20px; font-size: 0.78rem; font-weight: 700; }
.s-pending   { background: rgba(234,179,8,0.1);  color: #eab308; border: 1px solid rgba(234,179,8,0.25); }
.s-preparing { background: rgba(255,122,0,0.1);  color: #FF7A00; border: 1px solid rgba(255,122,0,0.25); }
.s-transit   { background: rgba(99,102,241,0.1); color: #818cf8; border: 1px solid rgba(99,102,241,0.25); }
.s-delivered { background: rgba(34,197,94,0.1);  color: #22c55e; border: 1px solid rgba(34,197,94,0.25); }
.s-cancelled { background: rgba(239,68,68,0.1);  color: #ef4444; border: 1px solid rgba(239,68,68,0.25); }

/* Timeline */
.timeline { position: relative; padding-left: 24px; }
.timeline::before { content:''; position:absolute; left:6px; top:8px; bottom:8px; width:2px; background:rgba(255,255,255,0.06); }
.tl-item { position: relative; padding-bottom: 20px; }
.tl-item:last-child { padding-bottom: 0; }
.tl-dot { position: absolute; left: -21px; width: 14px; height: 14px; border-radius: 50%; border: 2px solid rgba(255,255,255,0.1); background: #060608; top: 3px; }
.tl-dot.active { border-color: #FF7A00; background: #FF7A00; box-shadow: 0 0 8px rgba(255,122,0,0.5); }
.tl-dot.done { border-color: #22c55e; background: #22c55e; }
.tl-label { font-size: 0.82rem; font-weight: 600; color: rgba(255,255,255,0.5); }
.tl-label.active { color: #FF7A00; }
.tl-label.done { color: #22c55e; }
.tl-time { font-size: 0.72rem; color: rgba(255,255,255,0.25); margin-top: 2px; }
</style>
@endsection

@section('content')
<div class="admin-wrap">

    @include('admin.partials.sidebar')

    <main class="admin-main">
        @if(session('success'))
        <div class="flash-msg"><i class="fa-solid fa-circle-check"></i> {{ session('success') }}</div>
        @endif

        <a href="{{ route('admin.orders.index') }}" class="back-btn"><i class="fa-solid fa-arrow-left"></i> Back to Orders</a>

        <div class="order-header">
            <div>
                <h1>Order <span>#{{ $order->order_number }}</span></h1>
                <div class="order-date"><i class="fa-solid fa-calendar" style="margin-right:6px;color:#FF7A00;"></i>{{ $order->created_at->format('F d, Y — h:i A') }}</div>
            </div>
            @php
                $s = strtolower($order->status);
                $sc = 's-pending';
                if(in_array($s,['preparing','processing'])){ $sc='s-preparing'; }
                elseif(in_array($s,['out_for_delivery','shipped'])){ $sc='s-transit'; }
                elseif(in_array($s,['delivered','completed'])){ $sc='s-delivered'; }
                elseif($s==='cancelled'){ $sc='s-cancelled'; }
            @endphp
            <span class="status-pill {{ $sc }}">
                <i class="fa-solid fa-circle" style="font-size:0.5rem;"></i>
                {{ ucwords(str_replace('_',' ', $order->status)) }}
            </span>
        </div>

        <div class="detail-grid">
            {{-- Left --}}
            <div>
                {{-- Items --}}
                <div class="detail-card">
                    <h5>Items Ordered</h5>
                    <table class="items-table">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th style="text-align:center;">Qty</th>
                                <th style="text-align:right;">Unit Price</th>
                                <th style="text-align:right;">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td style="font-weight:600;">{{ $item->product_name }}</td>
                                <td style="text-align:center;"><span class="item-qty-badge">×{{ $item->quantity }}</span></td>
                                <td style="text-align:right;color:rgba(255,255,255,0.5);">Rs. {{ number_format($item->price, 0) }}</td>
                                <td style="text-align:right;font-weight:700;color:#FF7A00;">Rs. {{ number_format($item->total, 0) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" style="text-align:right;">Subtotal</td>
                                <td style="text-align:right;">Rs. {{ number_format($order->subtotal, 0) }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align:right;">Delivery Fee</td>
                                <td style="text-align:right;">Rs. {{ number_format($order->delivery_fee ?? $order->shipping ?? 0, 0) }}</td>
                            </tr>
                            @if(($order->platform_fee ?? 0) > 0)
                            <tr>
                                <td colspan="3" style="text-align:right;">Platform Fee</td>
                                <td style="text-align:right;">Rs. {{ number_format($order->platform_fee, 0) }}</td>
                            </tr>
                            @endif
                            <tr class="total-row">
                                <td colspan="3" style="text-align:right;">Grand Total</td>
                                <td style="text-align:right;">Rs. {{ number_format($order->total, 0) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                {{-- Notes --}}
                @if($order->notes)
                <div class="detail-card">
                    <h5>Order Notes</h5>
                    <p style="color:rgba(255,255,255,0.5);font-size:0.88rem;margin:0;">{{ $order->notes }}</p>
                </div>
                @endif
            </div>

            {{-- Right --}}
            <div>
                {{-- Status Update --}}
                <div class="detail-card" style="margin-bottom:16px;">
                    <h5>Update Status</h5>
                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                        @csrf @method('PATCH')
                        <select name="status" class="status-select">
                            <option value="pending"          {{ $order->status=='pending'?'selected':'' }}>⏳ Pending</option>
                            <option value="preparing"        {{ in_array($order->status,['preparing','processing'])?'selected':'' }}>🔥 Preparing</option>
                            <option value="ready"            {{ $order->status=='ready'?'selected':'' }}>✅ Ready for Pickup</option>
                            <option value="out_for_delivery" {{ in_array($order->status,['out_for_delivery','shipped'])?'selected':'' }}>🏍️ Out for Delivery</option>
                            <option value="delivered"        {{ in_array($order->status,['delivered','completed'])?'selected':'' }}>📦 Delivered</option>
                            <option value="cancelled"        {{ $order->status=='cancelled'?'selected':'' }}>❌ Cancelled</option>
                        </select>
                        <button type="submit" class="btn-update"><i class="fa-solid fa-arrows-rotate" style="margin-right:8px;"></i>Update Order Status</button>
                    </form>
                </div>

                {{-- Customer Info --}}
                <div class="detail-card" style="margin-bottom:16px;">
                    <h5>Customer Details</h5>
                    <div class="info-row">
                        <span class="info-label">Name</span>
                        <span class="info-val">{{ $order->first_name }} {{ $order->last_name }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Email</span>
                        <span class="info-val" style="font-size:0.78rem;">{{ $order->email }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Phone</span>
                        <span class="info-val">{{ $order->phone }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Address</span>
                        <span class="info-val" style="font-size:0.78rem;max-width:180px;">{{ $order->address }}, {{ $order->city }}</span>
                    </div>
                </div>

                {{-- Payment --}}
                <div class="detail-card">
                    <h5>Payment Info</h5>
                    <div class="info-row">
                        <span class="info-label">Method</span>
                        <span class="info-val" style="text-transform:uppercase;letter-spacing:1px;font-size:0.75rem;">{{ $order->payment_method }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Status</span>
                        <span class="info-val">
                            @if($order->payment_status === 'paid')
                                <span style="background:rgba(34,197,94,0.1);color:#22c55e;border:1px solid rgba(34,197,94,0.2);padding:3px 10px;border-radius:20px;font-size:0.72rem;font-weight:700;">✓ Paid</span>
                            @else
                                <span style="background:rgba(234,179,8,0.1);color:#eab308;border:1px solid rgba(234,179,8,0.2);padding:3px 10px;border-radius:20px;font-size:0.72rem;font-weight:700;">⏳ Pending</span>
                            @endif
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Amount</span>
                        <span class="info-val" style="color:#FF7A00;font-size:1.1rem;">Rs. {{ number_format($order->total, 0) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
