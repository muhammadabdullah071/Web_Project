@extends('layouts.app')
@section('title', 'Edit Restaurant - FoodDash Admin')

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

.back-btn { display: inline-flex; align-items: center; gap: 8px; color: rgba(255,255,255,0.4); text-decoration: none; font-size: 0.82rem; font-weight: 600; margin-bottom: 24px; transition: color 0.2s; }
.back-btn:hover { color: #FF7A00; }
.page-title { font-size: 1.8rem; font-weight: 800; color: #fff; margin: 0 0 6px; }
.page-title span { color: #FF7A00; }
.page-sub { font-size: 0.82rem; color: rgba(255,255,255,0.3); margin: 0 0 32px; }

.edit-grid { display: grid; grid-template-columns: 1fr 320px; gap: 20px; align-items: start; }
.form-card { background: #0C0C10; border: 1px solid rgba(255,255,255,0.05); border-radius: 20px; padding: 28px; }
.form-card h5 { font-size: 0.7rem; letter-spacing: 2.5px; text-transform: uppercase; color: rgba(255,122,0,0.7); margin: 0 0 22px; padding-bottom: 12px; border-bottom: 1px solid rgba(255,255,255,0.04); }
.f-group { margin-bottom: 20px; }
.f-group:last-child { margin-bottom: 0; }
.f-label { display: block; font-size: 0.72rem; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; color: rgba(255,255,255,0.35); margin-bottom: 8px; }
.f-input { width: 100%; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 12px; padding: 12px 16px; color: #fff; font-size: 0.9rem; transition: all 0.2s; outline: none; }
.f-input:focus { border-color: rgba(255,122,0,0.5); background: rgba(255,122,0,0.03); box-shadow: 0 0 0 3px rgba(255,122,0,0.08); }
.f-input::placeholder { color: rgba(255,255,255,0.2); }
.f-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.switch-wrap { display: flex; align-items: center; gap: 14px; background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.06); border-radius: 12px; padding: 14px 18px; }
.switch-wrap input[type=checkbox] { width: 44px; height: 22px; appearance: none; background: rgba(255,255,255,0.1); border-radius: 20px; position: relative; cursor: pointer; transition: background 0.2s; }
.switch-wrap input[type=checkbox]:checked { background: #FF7A00; }
.switch-wrap input[type=checkbox]::after { content: ''; position: absolute; width: 18px; height: 18px; background: white; border-radius: 50%; top: 2px; left: 2px; transition: left 0.2s; }
.switch-wrap input[type=checkbox]:checked::after { left: 24px; }
.switch-wrap label { font-size: 0.85rem; font-weight: 600; color: rgba(255,255,255,0.7); cursor: pointer; }

.preview-card { background: #0C0C10; border: 1px solid rgba(255,255,255,0.05); border-radius: 20px; overflow: hidden; }
.preview-img { width: 100%; height: 180px; object-fit: cover; display: block; }
.preview-info { padding: 18px; }
.preview-info h6 { font-weight: 700; color: #fff; margin: 0 0 6px; }
.preview-info p { font-size: 0.8rem; color: rgba(255,255,255,0.35); margin: 0; }

.info-box { background: rgba(255,122,0,0.05); border: 1px solid rgba(255,122,0,0.15); border-radius: 14px; padding: 16px; margin-top: 16px; font-size: 0.8rem; color: rgba(255,122,0,0.7); display: flex; gap: 10px; align-items: flex-start; }

.btn-save { background: linear-gradient(135deg,#FF7A00,#FF4500); border: none; border-radius: 12px; padding: 13px 28px; color: #fff; font-size: 0.9rem; font-weight: 700; cursor: pointer; transition: all 0.2s; width: 100%; }
.btn-save:hover { transform: translateY(-2px); box-shadow: 0 10px 25px rgba(255,122,0,0.3); }
.btn-discard { display: block; text-align: center; margin-top: 10px; color: rgba(255,255,255,0.3); font-size: 0.82rem; text-decoration: none; }
.btn-discard:hover { color: rgba(255,255,255,0.6); }

.err-list { background: rgba(239,68,68,0.08); border: 1px solid rgba(239,68,68,0.2); border-radius: 12px; padding: 14px 18px; margin-bottom: 20px; }
.err-list li { color: #ef4444; font-size: 0.82rem; }
</style>
@endsection

@section('content')
<div class="admin-wrap">

    @include('admin.partials.sidebar')

    <main class="admin-main">
        <a href="{{ route('admin.restaurants.index') }}" class="back-btn"><i class="fa-solid fa-arrow-left"></i> Back to Restaurants</a>
        <h1 class="page-title">Edit <span>Restaurant</span></h1>
        <p class="page-sub">Update partner configurations — changes apply instantly across the platform.</p>

        @if($errors->any())
        <ul class="err-list">
            @foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach
        </ul>
        @endif

        <form action="{{ route('admin.restaurants.update', $restaurant->id) }}" method="POST" id="editForm">
            @csrf @method('PATCH')

            <div class="edit-grid">
                {{-- Left: Form --}}
                <div>
                    <div class="form-card" style="margin-bottom:16px;">
                        <h5>Basic Information</h5>
                        <div class="f-row">
                            <div class="f-group">
                                <label class="f-label">Restaurant Name</label>
                                <input type="text" name="name" class="f-input" value="{{ old('name', $restaurant->name) }}" required>
                            </div>
                            <div class="f-group">
                                <label class="f-label">Phone Number</label>
                                <input type="text" name="phone" class="f-input" value="{{ old('phone', $restaurant->phone) }}" placeholder="+92 300 0000000">
                            </div>
                        </div>
                        <div class="f-group">
                            <label class="f-label">Operational Address</label>
                            <input type="text" name="address" class="f-input" value="{{ old('address', $restaurant->address) }}" required>
                        </div>
                        <div class="f-group">
                            <label class="f-label">Description</label>
                            <textarea name="description" class="f-input" rows="3" style="resize:vertical;">{{ old('description', $restaurant->description) }}</textarea>
                        </div>
                    </div>

                    <div class="form-card" style="margin-bottom:16px;">
                        <h5>Operational Settings</h5>
                        <div class="f-row">
                            <div class="f-group">
                                <label class="f-label">Delivery Time (minutes)</label>
                                <input type="number" name="delivery_time" class="f-input" value="{{ old('delivery_time', $restaurant->delivery_time) }}" min="0" required>
                            </div>
                            <div class="f-group">
                                <label class="f-label">Minimum Order (PKR)</label>
                                <input type="number" name="min_order" class="f-input" value="{{ old('min_order', $restaurant->min_order) }}" min="0" required>
                            </div>
                        </div>
                        <div class="f-group">
                            <label class="f-label">Restaurant Rating (read-only)</label>
                            <input type="number" step="0.1" name="rating" class="f-input" value="{{ $restaurant->rating }}" readonly style="opacity:0.5;cursor:not-allowed;">
                        </div>
                    </div>

                    <div class="form-card">
                        <h5>Media & Status</h5>
                        <div class="f-group">
                            <label class="f-label">Logo / Cover Image URL</label>
                            <input type="url" name="image" class="f-input" value="{{ old('image', $restaurant->image) }}" placeholder="https://example.com/image.jpg" id="imageUrlInput">
                        </div>
                        <div class="f-group">
                            <label class="f-label">Banner Image URL</label>
                            <input type="url" name="banner" class="f-input" value="{{ old('banner', $restaurant->banner) }}" placeholder="https://example.com/banner.jpg">
                        </div>
                        <div class="switch-wrap">
                            <input type="checkbox" name="is_active" id="isActive" {{ $restaurant->is_active ? 'checked' : '' }}>
                            <label for="isActive">Restaurant is <strong>Active</strong> — visible to customers</label>
                        </div>
                    </div>
                </div>

                {{-- Right: Preview & Save --}}
                <div>
                    <div class="preview-card" style="margin-bottom:16px;">
                        <img src="{{ $restaurant->display_image }}" class="preview-img" id="previewImg" alt="Preview">
                        <div class="preview-info">
                            <h6>{{ $restaurant->name }}</h6>
                            <p><i class="fa-solid fa-location-dot" style="color:#FF7A00;margin-right:4px;"></i>{{ $restaurant->address }}</p>
                            <div style="display:flex;gap:12px;margin-top:12px;font-size:0.78rem;color:rgba(255,255,255,0.4);">
                                <span><i class="fa-solid fa-clock" style="color:#818cf8;margin-right:3px;"></i>{{ $restaurant->delivery_time }} min</span>
                                <span><i class="fa-solid fa-star" style="color:#FF7A00;margin-right:3px;"></i>{{ $restaurant->rating }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-card">
                        <button type="submit" class="btn-save"><i class="fa-solid fa-cloud-arrow-up" style="margin-right:8px;"></i>Save Changes</button>
                        <a href="{{ route('admin.restaurants.index') }}" class="btn-discard">Discard & Go Back</a>
                    </div>

                    <div class="info-box">
                        <i class="fa-solid fa-circle-info" style="margin-top:2px;flex-shrink:0;"></i>
                        <span>Changes are applied instantly across the platform discovery network and customer-facing pages.</span>
                    </div>
                </div>
            </div>
        </form>
    </main>
</div>

<script>
// Live image preview
document.getElementById('imageUrlInput').addEventListener('input', function() {
    const img = document.getElementById('previewImg');
    if (this.value) {
        img.src = this.value;
        img.onerror = () => img.src = '{{ $restaurant->display_image }}';
    }
});
</script>
@endsection
