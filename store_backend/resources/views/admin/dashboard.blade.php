@extends('layouts.app')
@section('title', 'Command Center - FoodDash Admin')

@section('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');

* { font-family: 'Inter', sans-serif; }

.admin-wrap { display: flex; min-height: calc(100vh - 76px); background: #060608; }

/* ── Sidebar ── */
.admin-sidebar {
    width: 260px; min-width: 260px;
    background: #0C0C10;
    border-right: 1px solid rgba(255,122,0,0.08);
    padding: 32px 16px;
    position: sticky; top: 76px; height: calc(100vh - 76px);
    overflow-y: auto;
    display: flex; flex-direction: column;
}
.admin-sidebar::-webkit-scrollbar { width: 0; }
.sidebar-brand { padding: 0 12px 28px; border-bottom: 1px solid rgba(255,255,255,0.04); margin-bottom: 24px; }
.sidebar-brand h6 { font-size: 0.65rem; letter-spacing: 3px; color: rgba(255,122,0,0.6); text-transform: uppercase; margin-bottom: 4px; }
.sidebar-brand p { font-size: 0.8rem; color: rgba(255,255,255,0.4); margin: 0; }
.sidebar-section-label { font-size: 0.6rem; letter-spacing: 2.5px; color: rgba(255,255,255,0.2); text-transform: uppercase; padding: 0 12px; margin: 20px 0 8px; }
.s-link {
    display: flex; align-items: center; gap: 12px;
    padding: 11px 14px; border-radius: 12px;
    color: rgba(255,255,255,0.4); text-decoration: none;
    font-size: 0.875rem; font-weight: 500;
    transition: all 0.2s ease; margin-bottom: 2px;
}
.s-link i { width: 20px; text-align: center; font-size: 1rem; }
.s-link:hover, .s-link.active {
    background: rgba(255,122,0,0.1);
    color: #FF7A00;
}
.s-link .badge-count {
    margin-left: auto; background: rgba(255,122,0,0.2);
    color: #FF7A00; font-size: 0.65rem; padding: 2px 8px;
    border-radius: 20px; font-weight: 700;
}
.sidebar-logout { margin-top: auto; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.04); }

/* ── Main Content ── */
.admin-main { flex: 1; padding: 36px 40px; overflow-x: hidden; }

/* ── Top Bar ── */
.admin-topbar { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 36px; }
.admin-topbar h1 { font-size: 2rem; font-weight: 800; color: #fff; margin: 0; letter-spacing: -0.5px; }
.admin-topbar h1 span { color: #FF7A00; }
.topbar-live { display: flex; align-items: center; gap: 8px; background: rgba(34,197,94,0.08); border: 1px solid rgba(34,197,94,0.2); border-radius: 20px; padding: 6px 14px; }
.live-dot { width: 8px; height: 8px; background: #22c55e; border-radius: 50%; animation: livePulse 2s infinite; }
@keyframes livePulse { 0%,100%{ opacity:1; transform:scale(1); } 50%{ opacity:0.5; transform:scale(1.3); } }

/* ── Stat Cards ── */
.stat-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 16px; margin-bottom: 32px; }
.stat-card {
    background: #0F0F14;
    border: 1px solid rgba(255,255,255,0.06);
    border-radius: 20px; padding: 24px;
    position: relative; overflow: hidden;
    transition: all 0.3s ease;
}
.stat-card:hover { transform: translateY(-4px); border-color: rgba(255,122,0,0.3); box-shadow: 0 20px 40px rgba(0,0,0,0.5); }
.stat-card .glow { position: absolute; top: -30px; right: -30px; width: 100px; height: 100px; border-radius: 50%; filter: blur(40px); opacity: 0.15; }
.stat-label { font-size: 0.7rem; letter-spacing: 2px; text-transform: uppercase; color: rgba(255,255,255,0.35); margin-bottom: 12px; }
.stat-value { font-size: 2rem; font-weight: 800; color: #fff; letter-spacing: -1px; margin-bottom: 6px; line-height: 1; }
.stat-sub { font-size: 0.78rem; color: rgba(255,255,255,0.3); }
.stat-icon { position: absolute; top: 20px; right: 20px; width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; }

/* ── Live Ops Table ── */
.section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; }
.section-header h3 { font-size: 1.1rem; font-weight: 700; color: #fff; margin: 0; }
.ops-table-wrap { background: #0C0C10; border: 1px solid rgba(255,255,255,0.05); border-radius: 20px; overflow: hidden; }
.ops-table { width: 100%; border-collapse: collapse; }
.ops-table thead th { background: rgba(255,255,255,0.02); color: rgba(255,255,255,0.3); font-size: 0.65rem; letter-spacing: 2px; text-transform: uppercase; padding: 16px 20px; border-bottom: 1px solid rgba(255,255,255,0.04); font-weight: 600; }
.ops-table tbody td { padding: 16px 20px; border-bottom: 1px solid rgba(255,255,255,0.03); vertical-align: middle; font-size: 0.875rem; color: rgba(255,255,255,0.8); }
.ops-table tbody tr:last-child td { border-bottom: none; }
.ops-table tbody tr:hover td { background: rgba(255,255,255,0.015); }
.order-id { color: #FF7A00; font-weight: 700; font-size: 0.8rem; font-family: monospace; }
.status-pill {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 4px 12px; border-radius: 20px;
    font-size: 0.72rem; font-weight: 700; letter-spacing: 0.5px;
}
.status-pending   { background: rgba(234,179,8,0.1);  color: #eab308; border: 1px solid rgba(234,179,8,0.25); }
.status-preparing { background: rgba(255,122,0,0.1);  color: #FF7A00; border: 1px solid rgba(255,122,0,0.25); }
.status-transit   { background: rgba(99,102,241,0.1); color: #818cf8; border: 1px solid rgba(99,102,241,0.25); }
.status-delivered { background: rgba(34,197,94,0.1);  color: #22c55e; border: 1px solid rgba(34,197,94,0.25); }
.status-cancelled { background: rgba(239,68,68,0.1);  color: #ef4444; border: 1px solid rgba(239,68,68,0.25); }
.empty-state { text-align: center; padding: 60px 20px; color: rgba(255,255,255,0.25); }
.empty-state i { font-size: 3rem; margin-bottom: 16px; opacity: 0.3; display: block; }

/* ── Right Panel ── */
.right-panel { width: 300px; min-width: 300px; }
.metrics-card { background: #0C0C10; border: 1px solid rgba(255,255,255,0.05); border-radius: 20px; padding: 24px; margin-bottom: 16px; }
.metrics-card h6 { font-size: 0.75rem; letter-spacing: 2px; text-transform: uppercase; color: rgba(255,255,255,0.3); margin-bottom: 20px; }
.metric-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; }
.metric-row:last-child { margin-bottom: 0; }
.metric-label { font-size: 0.8rem; color: rgba(255,255,255,0.5); }
.metric-val { font-size: 0.85rem; font-weight: 700; color: #fff; }
.prog-bar { height: 4px; background: rgba(255,255,255,0.05); border-radius: 10px; margin-top: 6px; }
.prog-fill { height: 100%; border-radius: 10px; }
.quick-link { display: flex; align-items: center; gap: 12px; padding: 12px 14px; border-radius: 12px; background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.04); text-decoration: none; color: rgba(255,255,255,0.7); font-size: 0.85rem; font-weight: 500; margin-bottom: 8px; transition: all 0.2s; }
.quick-link:hover { background: rgba(255,122,0,0.08); color: #FF7A00; border-color: rgba(255,122,0,0.2); }
.quick-link i { color: #FF7A00; width: 20px; text-align: center; }

@media(max-width:1200px){ .right-panel{ display: none; } }
@media(max-width:992px){ .admin-sidebar{ display: none; } .stat-grid{ grid-template-columns: repeat(2,1fr); } }
</style>
@endsection

@section('content')
<div class="admin-wrap">

    @include('admin.partials.sidebar')

    {{-- ── Main ── --}}
    <main class="admin-main">

        {{-- Top Bar --}}
        <div class="admin-topbar">
            <div>
                <h1>{{ auth()->user()->role === 'owner' ? 'Partner' : 'System' }} <span>Intelligence</span></h1>
                <p style="font-size:0.82rem;color:rgba(255,255,255,0.3);margin:6px 0 0;">Real-time platform overview · {{ now()->format('l, F j Y') }}</p>
            </div>
            <div class="topbar-live">
                <div class="live-dot"></div>
                <span style="font-size:0.75rem;color:rgba(255,255,255,0.5);font-weight:600;">Live Sync</span>
            </div>
        </div>

        {{-- Session Overview Panel --}}
        <div style="background: rgba(255, 122, 0, 0.03); border: 1px solid rgba(255, 122, 0, 0.1); border-radius: 20px; padding: 24px; margin-bottom: 28px; display: flex; gap: 24px; align-items: center; justify-content: space-between; flex-wrap: wrap; backdrop-filter: blur(10px);">
            <div style="display: flex; gap: 18px; align-items: center;">
                <div style="position: relative;">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=FF7A00&color=fff&size=64" style="width: 64px; height: 64px; border-radius: 50%; border: 2px solid #FF7A00; box-shadow: 0 0 15px rgba(255, 122, 0, 0.3);">
                    <div style="position: absolute; bottom: 0; right: 0; width: 16px; height: 16px; border-radius: 50%; background: #22c55e; border: 3px solid #060608;" title="Online"></div>
                </div>
                <div>
                    <span style="font-size: 0.65rem; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: #FF7A00; display: block; margin-bottom: 4px;">Logged In Partner</span>
                    <h2 style="font-size: 1.25rem; font-weight: 800; color: #fff; margin: 0;">{{ auth()->user()->name }}</h2>
                    <span style="font-size: 0.8rem; color: rgba(255, 255, 255, 0.4); display: block; margin-top: 2px;">
                        <i class="fa-solid fa-envelope" style="margin-right: 5px; color: rgba(255,122,0,0.5);"></i> {{ auth()->user()->email }}
                        <span style="margin: 0 8px; color: rgba(255, 255, 255, 0.15);">|</span>
                        <i class="fa-solid fa-user-shield" style="margin-right: 5px; color: rgba(255,122,0,0.5);"></i> Role: <strong style="color: #fff; text-transform: capitalize;">{{ auth()->user()->role }}</strong>
                        <span style="margin: 0 8px; color: rgba(255, 255, 255, 0.15);">|</span>
                        <i class="fa-solid fa-calendar-days" style="margin-right: 5px; color: rgba(255,122,0,0.5);"></i> Joined: {{ auth()->user()->created_at->format('M Y') }}
                    </span>
                </div>
            </div>
            
            @if(auth()->user()->role === 'owner')
                @php
                    $myRestaurants = \App\Models\Restaurant::where('owner_id', auth()->id())->get();
                @endphp
                <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                    @forelse($myRestaurants as $rest)
                        <div style="background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255, 255, 255, 0.06); border-radius: 14px; padding: 12px 18px; display: flex; align-items: center; gap: 12px; transition: all 0.3s;" onmouseover="this.style.borderColor='rgba(255,122,0,0.3)'; this.style.background='rgba(255,122,0,0.02)';" onmouseout="this.style.borderColor='rgba(255,255,255,0.06)'; this.style.background='rgba(255,255,255,0.02)';" class="rest-session-card">
                            <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(255,122,0,0.1); display: flex; align-items: center; justify-content: center; border: 1px solid rgba(255,122,0,0.2);">
                                <i class="fa-solid fa-store" style="color: #FF7A00; font-size: 0.95rem;"></i>
                            </div>
                            <div>
                                <h4 style="font-size: 0.85rem; font-weight: 700; color: #fff; margin: 0;">{{ $rest->name }}</h4>
                                <span style="font-size: 0.72rem; color: rgba(255,255,255,0.35); display: flex; align-items: center; gap: 5px; margin-top: 2px;">
                                    <i class="fa-solid fa-star" style="color: #eab308; font-size: 0.65rem;"></i> {{ $rest->rating }} 
                                    <span style="color: rgba(255, 255, 255, 0.15);">•</span> 
                                    {{ $rest->address }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div style="font-size: 0.8rem; color: rgba(255,255,255,0.3); font-style: italic;">
                            No restaurants linked to this partner account.
                        </div>
                    @endforelse
                </div>
            @else
                <div style="background: rgba(99, 102, 241, 0.05); border: 1px solid rgba(99, 102, 241, 0.15); border-radius: 14px; padding: 12px 18px; display: flex; align-items: center; gap: 12px;">
                    <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(99, 102, 241, 0.1); display: flex; align-items: center; justify-content: center; border: 1px solid rgba(99, 102, 241, 0.2);">
                        <i class="fa-solid fa-shield-halved" style="color: #6366f1; font-size: 0.95rem;"></i>
                    </div>
                    <div>
                        <h4 style="font-size: 0.85rem; font-weight: 700; color: #fff; margin: 0;">Full Administrative Access</h4>
                        <span style="font-size: 0.72rem; color: rgba(255,255,255,0.35); display: block; margin-top: 2px;">Commanding all network restaurants & system nodes</span>
                    </div>
                </div>
            @endif
        </div>

        {{-- Stats Grid --}}
        <div class="stat-grid" id="dashboard-stats">
            <div class="stat-card">
                <div class="glow" style="background:#FF7A00;"></div>
                <div class="stat-icon" style="background:rgba(255,122,0,0.1);">
                    <i class="fa-solid fa-coins" style="color:#FF7A00;"></i>
                </div>
                <div class="stat-label">Gross Revenue</div>
                <div class="stat-value">₨{{ number_format($stats['total_revenue'] ?? 0, 0) }}</div>
                <div class="stat-sub">All-time platform earnings</div>
            </div>
            <div class="stat-card">
                <div class="glow" style="background:#818cf8;"></div>
                <div class="stat-icon" style="background:rgba(99,102,241,0.1);">
                    <i class="fa-solid fa-box-open" style="color:#818cf8;"></i>
                </div>
                <div class="stat-label">Total Orders</div>
                <div class="stat-value">{{ number_format($stats['total_orders'] ?? 0) }}</div>
                <div class="stat-sub">
                    <span style="color:#eab308;">{{ $stats['pending_orders'] ?? 0 }} pending</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="glow" style="background:#22c55e;"></div>
                <div class="stat-icon" style="background:rgba(34,197,94,0.1);">
                    <i class="fa-solid fa-store" style="color:#22c55e;"></i>
                </div>
                <div class="stat-label">Active Partners</div>
                <div class="stat-value">{{ $stats['active_restaurants'] ?? 0 }}</div>
                <div class="stat-sub">Restaurant network</div>
            </div>
            <div class="stat-card">
                <div class="glow" style="background:#38bdf8;"></div>
                <div class="stat-icon" style="background:rgba(56,189,248,0.1);">
                    <i class="fa-solid fa-user-check" style="color:#38bdf8;"></i>
                </div>
                <div class="stat-label">Verified Users</div>
                <div class="stat-value">{{ number_format($stats['total_users'] ?? 0) }}</div>
                <div class="stat-sub">Registered accounts</div>
            </div>
        </div>

        {{-- Live Ops + Right Panel --}}
        <div style="display:flex;gap:20px;align-items:flex-start;">
            {{-- Table --}}
            <div style="flex:1;min-width:0;">
                <div class="section-header">
                    <h3><i class="fa-solid fa-satellite-dish" style="color:#FF7A00;margin-right:10px;"></i>Live Operations</h3>
                    <a href="{{ route('admin.orders.index') }}" style="font-size:0.78rem;color:rgba(255,122,0,0.7);text-decoration:none;font-weight:600;">View All →</a>
                </div>
                <div class="ops-table-wrap">
                    <table class="ops-table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Restaurant</th>
                                <th>Value</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="dashboard-recent-orders-tbody">
                        @forelse($recentOrders as $order)
                            @php
                                $s = strtolower($order->status);
                                $sc = 'status-pending';
                                $si = 'receipt';
                                if(in_array($s,['preparing','processing'])){ $sc='status-preparing'; $si='fire'; }
                                elseif(in_array($s,['out_for_delivery','shipped','dispatched'])){ $sc='status-transit'; $si='motorcycle'; }
                                elseif(in_array($s,['delivered','completed'])){ $sc='status-delivered'; $si='circle-check'; }
                                elseif($s==='cancelled'){ $sc='status-cancelled'; $si='xmark'; }
                            @endphp
                            <tr>
                                <td><span class="order-id">#{{ $order->order_number }}</span></td>
                                <td>
                                    <div style="display:flex;align-items:center;gap:10px;">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($order->user->name ?? 'G') }}&background=1a1a1a&color=FF7A00&size=32" style="width:32px;height:32px;border-radius:50%;border:1px solid rgba(255,122,0,0.2);">
                                        <span style="font-weight:500;">{{ $order->user->name ?? 'Guest' }}</span>
                                    </div>
                                </td>
                                <td style="color:rgba(255,255,255,0.45);font-size:0.82rem;">{{ $order->restaurant->name ?? '—' }}</td>
                                <td style="font-weight:700;color:#FF7A00;">Rs.&nbsp;{{ number_format($order->total) }}</td>
                                <td><span class="status-pill {{ $sc }}"><i class="fa-solid fa-{{ $si }}" style="font-size:0.65rem;"></i> {{ ucfirst($order->status) }}</span></td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order->id) }}" style="color:rgba(255,255,255,0.3);text-decoration:none;font-size:0.9rem;" title="View Details">
                                        <i class="fa-solid fa-arrow-right"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="empty-state"><i class="fa-solid fa-inbox"></i>No orders yet — waiting for the first transaction.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Right Panel --}}
            <div class="right-panel">
                <div class="metrics-card">
                    <h6>Platform Health</h6>
                    <div class="metric-row">
                        <div>
                            <div class="metric-label">Infrastructure Uptime</div>
                            <div class="prog-bar"><div class="prog-fill" style="width:100%;background:#22c55e;"></div></div>
                        </div>
                        <div class="metric-val" style="color:#22c55e;">99.9%</div>
                    </div>
                    <div class="metric-row">
                        <div>
                            <div class="metric-label">Delivery Fleet Active</div>
                            <div class="prog-bar"><div class="prog-fill" style="width:98%;background:#FF7A00;"></div></div>
                        </div>
                        <div class="metric-val" style="color:#FF7A00;">98%</div>
                    </div>
                    <div class="metric-row">
                        <div>
                            <div class="metric-label">Order Success Rate</div>
                            <div class="prog-bar"><div class="prog-fill" style="width:99.4%;background:#818cf8;"></div></div>
                        </div>
                        <div class="metric-val" style="color:#818cf8;">99.4%</div>
                    </div>
                </div>

                <div class="metrics-card">
                    <h6>Quick Actions</h6>
                    <a href="{{ route('admin.restaurants.create') }}" class="quick-link"><i class="fa-solid fa-plus"></i> Add Restaurant</a>
                    <a href="{{ route('admin.products.create') }}" class="quick-link"><i class="fa-solid fa-utensils"></i> Add Menu Item</a>
                    <a href="{{ route('admin.orders.index') }}" class="quick-link"><i class="fa-solid fa-receipt"></i> Manage Orders</a>
                    <a href="{{ route('admin.customers') }}" class="quick-link"><i class="fa-solid fa-users"></i> View Customers</a>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
// High-fidelity Auto-refresh for premium real-time operations dashboard
const liveBadge = document.querySelector('.topbar-live');
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

            // 1. Update stats grid
            const newStats = doc.getElementById('dashboard-stats');
            const currentStats = document.getElementById('dashboard-stats');
            if (newStats && currentStats) {
                currentStats.innerHTML = newStats.innerHTML;
            }

            // 2. Update recent orders table
            const newTable = doc.getElementById('dashboard-recent-orders-tbody');
            const currentTable = document.getElementById('dashboard-recent-orders-tbody');
            if (newTable && currentTable) {
                currentTable.innerHTML = newTable.innerHTML;
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

// Sync every 5 seconds for ultimate real-time feel
setInterval(performLiveSync, 5000);
</script>
@endsection
