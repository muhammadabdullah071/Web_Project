<aside class="admin-sidebar">
    <div class="sidebar-brand">
        <h6>{{ auth()->user()->role === 'owner' ? 'Partner Portal' : 'System Admin' }}</h6>
        <p>{{ auth()->user()->name }}</p>
    </div>
    
    <span class="sidebar-section-label">Platform Core</span>
    <a href="{{ route('admin.dashboard') }}" class="s-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="fa-solid fa-gauge-high"></i> Command Center
    </a>
    
    <a href="{{ route('admin.restaurants.index') }}" class="s-link {{ request()->routeIs('admin.restaurants.*') ? 'active' : '' }}">
        <i class="fa-solid fa-store"></i> {{ auth()->user()->role === 'owner' ? 'My Restaurants' : 'Restaurants' }}
    </a>
    
    <a href="{{ route('admin.food-items') }}" class="s-link {{ (request()->routeIs('admin.food-items') || request()->routeIs('admin.products.*')) ? 'active' : '' }}">
        <i class="fa-solid fa-utensils"></i> {{ auth()->user()->role === 'owner' ? 'My Menu Items' : 'Menu Items' }}
    </a>
    
    <a href="{{ route('admin.orders.index') }}" class="s-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
        <i class="fa-solid fa-receipt"></i> {{ auth()->user()->role === 'owner' ? 'Restaurant Orders' : 'Live Orders' }}
        @php 
            $pendingQuery = \App\Models\Order::where('status', 'pending');
            if (auth()->user()->role === 'owner') {
                $pendingQuery->whereHas('restaurant', function($q) {
                    $q->where('owner_id', auth()->id());
                });
            }
            $pendingCount = $pendingQuery->count(); 
        @endphp
        @if($pendingCount > 0)
            <span class="badge-count">{{ $pendingCount }}</span>
        @endif
    </a>
    
    @if(auth()->user()->role !== 'owner')
        <span class="sidebar-section-label">Logistics</span>
        <a href="{{ route('admin.riders') }}" class="s-link {{ request()->routeIs('admin.riders') ? 'active' : '' }}">
            <i class="fa-solid fa-motorcycle"></i> Fleet Ops
        </a>
        <a href="{{ route('admin.customers') }}" class="s-link {{ request()->routeIs('admin.customers') ? 'active' : '' }}">
            <i class="fa-solid fa-users"></i> Customers
        </a>
        <a href="{{ route('admin.coupons') }}" class="s-link {{ request()->routeIs('admin.coupons') ? 'active' : '' }}">
            <i class="fa-solid fa-ticket-simple"></i> Promotions
        </a>
    @endif
    
    <div class="sidebar-logout">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="s-link w-100 border-0 bg-transparent text-start" style="color:rgba(239,68,68,0.6);">
                <i class="fa-solid fa-power-off"></i> Secure Exit
            </button>
        </form>
    </div>
</aside>
