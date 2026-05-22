@extends('layouts.app')
@section('title', 'Menu Management - FoodDash Admin')

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

.page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px; }
.page-header h1 { font-size: 1.8rem; font-weight: 800; color: #fff; margin: 0; }
.page-header h1 span { color: #FF7A00; }
.btn-add { background: linear-gradient(135deg,#FF7A00,#FF4500); color: #fff; border: none; border-radius: 12px; padding: 10px 22px; font-size: 0.85rem; font-weight: 700; display: inline-flex; align-items: center; gap: 8px; text-decoration: none; transition: all 0.2s; }
.btn-add:hover { transform: translateY(-2px); box-shadow: 0 10px 25px rgba(255,122,0,0.35); color: #fff; }

.flash-msg { background: rgba(34,197,94,0.08); border: 1px solid rgba(34,197,94,0.2); color: #22c55e; padding: 12px 18px; border-radius: 12px; margin-bottom: 20px; font-size: 0.85rem; font-weight: 600; display: flex; align-items: center; gap: 10px; }

/* Filters */
.filter-bar { display: flex; gap: 12px; margin-bottom: 20px; align-items: center; flex-wrap: wrap; }
.filter-select { background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 10px; padding: 9px 14px; color: rgba(255,255,255,0.7); font-size: 0.82rem; outline: none; cursor: pointer; }
.filter-select:focus { border-color: rgba(255,122,0,0.4); }
.filter-select option { background: #0C0C10; }
.search-input { background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 10px; padding: 9px 14px; color: rgba(255,255,255,0.7); font-size: 0.82rem; outline: none; width: 200px; }
.search-input::placeholder { color: rgba(255,255,255,0.2); }
.search-input:focus { border-color: rgba(255,122,0,0.4); }

.data-table-wrap { background: #0C0C10; border: 1px solid rgba(255,255,255,0.05); border-radius: 20px; overflow: hidden; }
.data-table { width: 100%; border-collapse: collapse; }
.data-table thead th { background: rgba(255,255,255,0.02); color: rgba(255,255,255,0.3); font-size: 0.65rem; letter-spacing: 2px; text-transform: uppercase; padding: 16px 20px; border-bottom: 1px solid rgba(255,255,255,0.04); font-weight: 600; }
.data-table tbody td { padding: 14px 20px; border-bottom: 1px solid rgba(255,255,255,0.03); vertical-align: middle; color: rgba(255,255,255,0.8); font-size: 0.875rem; }
.data-table tbody tr:last-child td { border-bottom: none; }
.data-table tbody tr:hover td { background: rgba(255,255,255,0.015); }

.item-img { width: 48px; height: 48px; border-radius: 10px; object-fit: cover; border: 1px solid rgba(255,255,255,0.08); }
.item-name { font-weight: 700; color: #fff; font-size: 0.88rem; }
.item-meta { font-size: 0.72rem; color: rgba(255,255,255,0.3); margin-top: 2px; }
.cat-badge { background: rgba(99,102,241,0.1); color: #818cf8; border: 1px solid rgba(99,102,241,0.2); padding: 3px 10px; border-radius: 20px; font-size: 0.7rem; font-weight: 600; }
.rest-tag { background: rgba(255,122,0,0.08); color: rgba(255,122,0,0.8); padding: 3px 10px; border-radius: 20px; font-size: 0.7rem; font-weight: 600; }
.price-val { font-weight: 800; color: #FF7A00; font-size: 0.9rem; }
.sale-val { font-size: 0.75rem; color: #22c55e; display: block; }
.stock-ok { color: #22c55e; font-weight: 700; font-size: 0.8rem; }
.stock-low { color: #ef4444; font-weight: 700; font-size: 0.8rem; }
.status-on { background: rgba(34,197,94,0.1); color: #22c55e; border: 1px solid rgba(34,197,94,0.25); padding: 3px 10px; border-radius: 20px; font-size: 0.7rem; font-weight: 700; }
.status-off { background: rgba(255,255,255,0.05); color: rgba(255,255,255,0.3); border: 1px solid rgba(255,255,255,0.08); padding: 3px 10px; border-radius: 20px; font-size: 0.7rem; font-weight: 700; }
.featured-star { color: #eab308; font-size: 0.8rem; }
.action-btn { display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 9px; border: 1px solid rgba(255,255,255,0.08); background: rgba(255,255,255,0.03); color: rgba(255,255,255,0.5); text-decoration: none; transition: all 0.2s; font-size: 0.82rem; }
.action-btn:hover { border-color: rgba(255,122,0,0.4); color: #FF7A00; background: rgba(255,122,0,0.08); }
.action-btn.danger:hover { border-color: rgba(239,68,68,0.4); color: #ef4444; background: rgba(239,68,68,0.08); }
.action-btn button { background: none; border: none; color: inherit; padding: 0; line-height: 1; font-size: inherit; }
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
            <h1>{{ auth()->user()->role === 'owner' ? 'My Menu' : 'Menu' }} <span>{{ auth()->user()->role === 'owner' ? 'Items' : 'Inventory' }}</span></h1>
            <a href="{{ route('admin.products.create') }}" class="btn-add"><i class="fa-solid fa-plus"></i> Add Item</a>
        </div>

        <div class="data-table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Restaurant</th>
                        <th>Category</th>
                        <th>Price (PKR)</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th style="text-align:right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($foodItems as $item)
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:14px;">
                                <img src="{{ $item->display_image }}" class="item-img" alt="{{ $item->name }}">
                                <div>
                                    <div class="item-name">
                                        {{ $item->name }}
                                        @if($item->is_featured) <i class="fa-solid fa-star featured-star" title="Featured"></i> @endif
                                    </div>
                                    <div class="item-meta">{{ $item->preparation_time ?? 15 }} min prep</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="rest-tag">{{ $item->restaurant->name ?? '—' }}</span></td>
                        <td><span class="cat-badge">{{ $item->category->name ?? '—' }}</span></td>
                        <td>
                            <span class="price-val">Rs. {{ number_format($item->display_price, 0) }}</span>
                            @if($item->sale_price && $item->sale_price < $item->price)
                                <span class="sale-val"><s style="color:rgba(255,255,255,0.25);">Rs. {{ number_format($item->price, 0) }}</s> Sale</span>
                            @endif
                        </td>
                        <td>
                            @if($item->quantity > 5)
                                <span class="stock-ok"><i class="fa-solid fa-circle-check" style="margin-right:4px;font-size:0.75rem;"></i>{{ $item->quantity }}</span>
                            @else
                                <span class="stock-low"><i class="fa-solid fa-triangle-exclamation" style="margin-right:4px;font-size:0.75rem;"></i>{{ $item->quantity }} Low</span>
                            @endif
                        </td>
                        <td>
                            @if($item->is_active)
                                <span class="status-on">Live</span>
                            @else
                                <span class="status-off">Hidden</span>
                            @endif
                        </td>
                        <td style="text-align:right;">
                            <div style="display:flex;align-items:center;justify-content:flex-end;gap:8px;">
                                <a href="{{ route('products.show', $item->slug) }}" class="action-btn" title="View on Site" target="_blank"><i class="fa-solid fa-eye"></i></a>
                                <a href="{{ route('admin.products.edit', $item->id) }}" class="action-btn" title="Edit Item"><i class="fa-solid fa-pen"></i></a>
                                <span class="action-btn danger" title="Delete Item">
                                    <form action="{{ route('admin.products.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Delete {{ addslashes($item->name) }}?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </span>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align:center;padding:60px;color:rgba(255,255,255,0.25);">
                            <i class="fa-solid fa-bowl-food" style="font-size:2.5rem;display:block;margin-bottom:12px;opacity:0.3;"></i>
                            No menu items yet — start by adding your first dish.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="pagination-wrap">
                <a href="{{ $foodItems->previousPageUrl() ?? '#' }}" class="page-btn {{ $foodItems->onFirstPage() ? 'disabled' : '' }}"><i class="fa-solid fa-chevron-left" style="margin-right:6px;"></i>Previous</a>
                <span class="page-info">Page {{ $foodItems->currentPage() }} of {{ $foodItems->lastPage() }} · {{ $foodItems->total() }} items</span>
                <a href="{{ $foodItems->nextPageUrl() ?? '#' }}" class="page-btn {{ !$foodItems->hasMorePages() ? 'disabled' : '' }}">Next<i class="fa-solid fa-chevron-right" style="margin-left:6px;"></i></a>
            </div>
        </div>
    </main>
</div>
@endsection
