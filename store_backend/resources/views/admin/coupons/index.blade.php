@extends('layouts.app')
@section('title', 'Promotions - FoodDash Admin')

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
.page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px; }
.page-header h1 { font-size: 1.8rem; font-weight: 800; color: #fff; margin: 0; }
.page-header h1 span { color: #FF7A00; }
.btn-add { background: linear-gradient(135deg,#FF7A00,#FF4500); color: #fff; border: none; border-radius: 12px; padding: 10px 22px; font-size: 0.85rem; font-weight: 700; display: inline-flex; align-items: center; gap: 8px; cursor: pointer; transition: all 0.2s; }
.btn-add:hover { transform: translateY(-2px); box-shadow: 0 10px 25px rgba(255,122,0,0.35); }

/* Coupon grid */
.coupon-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 16px; margin-bottom: 32px; }
.coupon-card { background: #0C0C10; border: 1px solid rgba(255,255,255,0.06); border-radius: 20px; padding: 24px; position: relative; overflow: hidden; transition: all 0.25s; }
.coupon-card:hover { transform: translateY(-4px); border-color: rgba(255,122,0,0.25); box-shadow: 0 16px 40px rgba(0,0,0,0.5); }
.coupon-card::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; background: linear-gradient(90deg,#FF7A00,#FF4500); }
.coupon-badge { font-size: 2.2rem; font-weight: 900; color: #FF7A00; letter-spacing: -1px; font-family: monospace; margin-bottom: 4px; }
.coupon-name { font-size: 1rem; font-weight: 700; color: #fff; margin-bottom: 6px; }
.coupon-desc { font-size: 0.8rem; color: rgba(255,255,255,0.35); margin-bottom: 16px; line-height: 1.5; }
.coupon-meta { display: flex; gap: 12px; flex-wrap: wrap; margin-bottom: 16px; }
.meta-chip { background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08); border-radius: 8px; padding: 5px 12px; font-size: 0.72rem; color: rgba(255,255,255,0.5); }
.meta-chip i { margin-right: 5px; color: #FF7A00; }
.coupon-active { background: rgba(34,197,94,0.1); color: #22c55e; border: 1px solid rgba(34,197,94,0.2); border-radius: 20px; padding: 4px 12px; font-size: 0.7rem; font-weight: 700; display: inline-flex; align-items: center; gap: 5px; }
.coupon-expired { background: rgba(239,68,68,0.1); color: #ef4444; border: 1px solid rgba(239,68,68,0.2); border-radius: 20px; padding: 4px 12px; font-size: 0.7rem; font-weight: 700; }
.deco-dots { position: absolute; right: -10px; top: 50%; transform: translateY(-50%); display: flex; flex-direction: column; gap: 8px; }
.deco-dot { width: 20px; height: 20px; border-radius: 50%; background: #060608; }

/* Create coupon form */
.create-card { background: #0C0C10; border: 1px solid rgba(255,122,0,0.12); border-radius: 20px; padding: 28px; }
.create-card h5 { font-size: 0.7rem; letter-spacing: 2.5px; text-transform: uppercase; color: rgba(255,122,0,0.7); margin: 0 0 22px; padding-bottom: 12px; border-bottom: 1px solid rgba(255,255,255,0.04); }
.f-group { margin-bottom: 18px; }
.f-group:last-child { margin-bottom: 0; }
.f-label { display: block; font-size: 0.72rem; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; color: rgba(255,255,255,0.3); margin-bottom: 8px; }
.f-input { width: 100%; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 12px; padding: 11px 16px; color: #fff; font-size: 0.88rem; outline: none; font-family: 'Inter', sans-serif; transition: border-color 0.2s; }
.f-input:focus { border-color: rgba(255,122,0,0.4); }
.f-input::placeholder { color: rgba(255,255,255,0.2); }
.f-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
.btn-create { background: linear-gradient(135deg,#FF7A00,#FF4500); border: none; border-radius: 12px; padding: 12px 24px; color: #fff; font-size: 0.88rem; font-weight: 700; cursor: pointer; width: 100%; transition: all 0.2s; }
.btn-create:hover { transform: translateY(-1px); box-shadow: 0 8px 20px rgba(255,122,0,0.3); }

.empty-state { text-align: center; padding: 60px 20px; color: rgba(255,255,255,0.2); }
.empty-state i { font-size: 3rem; display: block; margin-bottom: 16px; }
</style>
@endsection

@section('content')
<div class="admin-wrap">
    <aside class="admin-sidebar">
        <div class="sidebar-brand">
            <h6>{{ auth()->user()->role === 'owner' ? 'Partner Portal' : 'System Admin' }}</h6>
            <p>{{ auth()->user()->name }}</p>
        </div>
        <span class="sidebar-section-label">Platform Core</span>
        <a href="{{ route('admin.dashboard') }}" class="s-link"><i class="fa-solid fa-gauge-high"></i> Command Center</a>
        <a href="{{ route('admin.restaurants.index') }}" class="s-link"><i class="fa-solid fa-store"></i> Restaurants</a>
        <a href="{{ route('admin.food-items') }}" class="s-link"><i class="fa-solid fa-utensils"></i> Menu Items</a>
        <a href="{{ route('admin.orders.index') }}" class="s-link"><i class="fa-solid fa-receipt"></i> Live Orders</a>
        <span class="sidebar-section-label">Logistics</span>
        <a href="{{ route('admin.riders') }}" class="s-link"><i class="fa-solid fa-motorcycle"></i> Fleet Ops</a>
        <a href="{{ route('admin.customers') }}" class="s-link"><i class="fa-solid fa-users"></i> Customers</a>
        <a href="{{ route('admin.coupons') }}" class="s-link active"><i class="fa-solid fa-ticket-simple"></i> Promotions</a>
        <div class="sidebar-logout">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="s-link w-100 border-0 bg-transparent text-start" style="color:rgba(239,68,68,0.6);">
                    <i class="fa-solid fa-power-off"></i> Secure Exit
                </button>
            </form>
        </div>
    </aside>

    <main class="admin-main">
        <div class="page-header">
            <h1>Promotions & <span>Coupons</span></h1>
        </div>

        {{-- Active coupons (hardcoded examples until DB table exists) --}}
        <div style="font-size:0.7rem;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,0.25);margin-bottom:16px;">Active Campaigns</div>
        <div class="coupon-grid">
            @php
                $sampleCoupons = [
                    ['code'=>'WELCOME20','name'=>'Welcome Discount','desc'=>'20% off on your first order — valid for all new customers.','discount'=>'20%','type'=>'Percentage','min'=>'Rs. 500','uses'=>'∞','active'=>true],
                    ['code'=>'SAVE500','name'=>'Flat 500 Off','desc'=>'Rs. 500 flat discount on orders above Rs. 2,000.','discount'=>'Rs. 500','type'=>'Fixed','min'=>'Rs. 2,000','uses'=>'1/user','active'=>true],
                    ['code'=>'FREESHIP','name'=>'Free Delivery','desc'=>'Zero delivery charges on any order from any partner restaurant.','discount'=>'Free Shipping','type'=>'Delivery','min'=>'Rs. 300','uses'=>'∞','active'=>false],
                ];
            @endphp

            @foreach($sampleCoupons as $c)
            <div class="coupon-card">
                <div class="deco-dots">
                    <div class="deco-dot"></div>
                    <div class="deco-dot"></div>
                </div>
                <div class="coupon-badge">{{ $c['code'] }}</div>
                <div class="coupon-name">{{ $c['name'] }}</div>
                <div class="coupon-desc">{{ $c['desc'] }}</div>
                <div class="coupon-meta">
                    <span class="meta-chip"><i class="fa-solid fa-tag"></i>{{ $c['discount'] }}</span>
                    <span class="meta-chip"><i class="fa-solid fa-layer-group"></i>{{ $c['type'] }}</span>
                    <span class="meta-chip"><i class="fa-solid fa-cart-shopping"></i>Min {{ $c['min'] }}</span>
                </div>
                @if($c['active'])
                    <span class="coupon-active"><i class="fa-solid fa-circle" style="font-size:0.5rem;"></i>Active</span>
                @else
                    <span class="coupon-expired">Expired</span>
                @endif
            </div>
            @endforeach
        </div>

        {{-- Create New --}}
        <div style="font-size:0.7rem;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,0.25);margin-bottom:16px;">Create New Coupon</div>
        <div class="create-card">
            <h5>Coupon Configuration</h5>
            <form>
                <div class="f-row" style="margin-bottom:18px;">
                    <div class="f-group">
                        <label class="f-label">Coupon Code</label>
                        <input type="text" class="f-input" placeholder="e.g. SUMMER30" style="text-transform:uppercase;">
                    </div>
                    <div class="f-group">
                        <label class="f-label">Discount Value</label>
                        <input type="text" class="f-input" placeholder="e.g. 20% or 500">
                    </div>
                </div>
                <div class="f-row" style="margin-bottom:18px;">
                    <div class="f-group">
                        <label class="f-label">Discount Type</label>
                        <select class="f-input">
                            <option>Percentage</option>
                            <option>Fixed Amount</option>
                            <option>Free Delivery</option>
                        </select>
                    </div>
                    <div class="f-group">
                        <label class="f-label">Minimum Order (PKR)</label>
                        <input type="number" class="f-input" placeholder="0">
                    </div>
                </div>
                <div class="f-group" style="margin-bottom:18px;">
                    <label class="f-label">Description</label>
                    <input type="text" class="f-input" placeholder="Customer-facing description">
                </div>
                <button type="button" class="btn-create" onclick="alert('Coupon database table coming soon! Contact dev to enable.')">
                    <i class="fa-solid fa-plus" style="margin-right:8px;"></i>Create Coupon
                </button>
            </form>
        </div>
    </main>
</div>
@endsection
