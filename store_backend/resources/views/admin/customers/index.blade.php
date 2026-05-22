@extends('layouts.app')
@section('title', 'Customer Base - FoodDash Admin')

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
.stat-mini { display: flex; gap: 16px; margin-bottom: 24px; }
.stat-mini-card { background: #0C0C10; border: 1px solid rgba(255,255,255,0.05); border-radius: 16px; padding: 18px 24px; flex: 1; }
.stat-mini-card .val { font-size: 1.8rem; font-weight: 800; color: #fff; }
.stat-mini-card .lbl { font-size: 0.7rem; letter-spacing: 1.5px; text-transform: uppercase; color: rgba(255,255,255,0.3); }
.data-table-wrap { background: #0C0C10; border: 1px solid rgba(255,255,255,0.05); border-radius: 20px; overflow: hidden; }
.data-table { width: 100%; border-collapse: collapse; }
.data-table thead th { background: rgba(255,255,255,0.02); color: rgba(255,255,255,0.3); font-size: 0.65rem; letter-spacing: 2px; text-transform: uppercase; padding: 16px 20px; border-bottom: 1px solid rgba(255,255,255,0.04); font-weight: 600; }
.data-table tbody td { padding: 15px 20px; border-bottom: 1px solid rgba(255,255,255,0.03); vertical-align: middle; color: rgba(255,255,255,0.8); font-size: 0.875rem; }
.data-table tbody tr:last-child td { border-bottom: none; }
.data-table tbody tr:hover td { background: rgba(255,255,255,0.012); }
.cust-avatar { width: 38px; height: 38px; border-radius: 10px; object-fit: cover; }
.role-badge { padding: 3px 10px; border-radius: 20px; font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
.role-customer { background: rgba(56,189,248,0.1); color: #38bdf8; border: 1px solid rgba(56,189,248,0.2); }
.role-owner    { background: rgba(255,122,0,0.1);  color: #FF7A00; border: 1px solid rgba(255,122,0,0.2); }
.role-admin    { background: rgba(239,68,68,0.1);  color: #ef4444; border: 1px solid rgba(239,68,68,0.2); }
.action-btn { display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 9px; border: 1px solid rgba(255,255,255,0.08); background: rgba(255,255,255,0.03); color: rgba(255,255,255,0.4); cursor: pointer; transition: all 0.2s; font-size: 0.82rem; }
.action-btn:hover { border-color: rgba(255,122,0,0.4); color: #FF7A00; background: rgba(255,122,0,0.08); }
.pagination-wrap { display: flex; justify-content: space-between; align-items: center; padding: 16px 20px; border-top: 1px solid rgba(255,255,255,0.04); }
.page-btn { background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08); color: rgba(255,255,255,0.5); border-radius: 10px; padding: 8px 18px; font-size: 0.8rem; font-weight: 600; text-decoration: none; transition: all 0.2s; }
.page-btn:hover:not(.disabled) { background: rgba(255,122,0,0.1); border-color: rgba(255,122,0,0.3); color: #FF7A00; }
.page-btn.disabled { opacity: 0.3; pointer-events: none; }
.page-info { font-size: 0.78rem; color: rgba(255,255,255,0.3); }
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
        <a href="{{ route('admin.customers') }}" class="s-link active"><i class="fa-solid fa-users"></i> Customers</a>
        <a href="{{ route('admin.coupons') }}" class="s-link"><i class="fa-solid fa-ticket-simple"></i> Promotions</a>
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
            <h1>Customer <span>Base</span></h1>
        </div>

        <div class="stat-mini">
            <div class="stat-mini-card">
                <div class="lbl">Total Accounts</div>
                <div class="val">{{ $customers->total() }}</div>
            </div>
            <div class="stat-mini-card">
                <div class="lbl">New This Month</div>
                <div class="val" style="color:#FF7A00;">{{ $customers->getCollection()->filter(fn($c) => $c->created_at->isCurrentMonth())->count() }}</div>
            </div>
            <div class="stat-mini-card">
                <div class="lbl">Platform</div>
                <div class="val" style="color:#22c55e;font-size:1.2rem;">FoodDash</div>
            </div>
        </div>

        <div class="data-table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Role</th>
                        <th>Joined</th>
                        <th style="text-align:right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $customer)
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:12px;">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($customer->name) }}&background=1a1a1a&color=FF7A00&size=38" class="cust-avatar" alt="{{ $customer->name }}">
                                <div style="font-weight:600;color:#fff;">{{ $customer->name }}</div>
                            </div>
                        </td>
                        <td style="color:rgba(255,255,255,0.45);font-size:0.82rem;">{{ $customer->email }}</td>
                        <td style="color:rgba(255,255,255,0.45);font-size:0.82rem;">{{ $customer->phone ?? '—' }}</td>
                        <td>
                            @php $role = $customer->role ?? 'customer'; @endphp
                            <span class="role-badge role-{{ $role }}">{{ ucfirst($role) }}</span>
                        </td>
                        <td style="color:rgba(255,255,255,0.35);font-size:0.78rem;">{{ $customer->created_at->format('M d, Y') }}</td>
                        <td style="text-align:right;">
                            <div style="display:flex;justify-content:flex-end;gap:8px;">
                                <button class="action-btn" title="View Orders"><i class="fa-solid fa-receipt"></i></button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align:center;padding:60px;color:rgba(255,255,255,0.25);">
                            <i class="fa-solid fa-users" style="font-size:2.5rem;display:block;margin-bottom:12px;opacity:0.3;"></i>
                            No customers registered yet.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="pagination-wrap">
                <a href="{{ $customers->previousPageUrl() ?? '#' }}" class="page-btn {{ $customers->onFirstPage() ? 'disabled' : '' }}"><i class="fa-solid fa-chevron-left" style="margin-right:6px;"></i>Previous</a>
                <span class="page-info">{{ $customers->total() }} customers · Page {{ $customers->currentPage() }}</span>
                <a href="{{ $customers->nextPageUrl() ?? '#' }}" class="page-btn {{ !$customers->hasMorePages() ? 'disabled' : '' }}">Next<i class="fa-solid fa-chevron-right" style="margin-left:6px;"></i></a>
            </div>
        </div>
    </main>
</div>
@endsection
