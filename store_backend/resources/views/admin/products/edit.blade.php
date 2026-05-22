@extends('layouts.app')
@section('title', 'Edit Menu Item - FoodDash Admin')

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

.edit-grid { display: grid; grid-template-columns: 1fr 300px; gap: 20px; align-items: start; }
.form-card { background: #0C0C10; border: 1px solid rgba(255,255,255,0.05); border-radius: 20px; padding: 28px; margin-bottom: 16px; }
.form-card h5 { font-size: 0.7rem; letter-spacing: 2.5px; text-transform: uppercase; color: rgba(255,122,0,0.7); margin: 0 0 22px; padding-bottom: 12px; border-bottom: 1px solid rgba(255,255,255,0.04); }
.f-group { margin-bottom: 20px; }
.f-group:last-child { margin-bottom: 0; }
.f-label { display: block; font-size: 0.72rem; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; color: rgba(255,255,255,0.35); margin-bottom: 8px; }
.f-input, .f-select, .f-textarea { width: 100%; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 12px; padding: 12px 16px; color: #fff; font-size: 0.9rem; transition: all 0.2s; outline: none; font-family: 'Inter', sans-serif; }
.f-input:focus, .f-select:focus, .f-textarea:focus { border-color: rgba(255,122,0,0.5); background: rgba(255,122,0,0.03); box-shadow: 0 0 0 3px rgba(255,122,0,0.08); }
.f-input::placeholder, .f-textarea::placeholder { color: rgba(255,255,255,0.2); }
.f-select option { background: #111; }
.f-textarea { resize: vertical; }
.f-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.price-input-wrap { position: relative; }
.price-prefix { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: rgba(255,122,0,0.7); font-weight: 700; font-size: 0.85rem; }
.price-field { padding-left: 42px !important; }

.switch-row { display: flex; align-items: center; gap: 14px; padding: 14px 0; border-bottom: 1px solid rgba(255,255,255,0.04); }
.switch-row:last-child { border-bottom: none; }
.toggle { width: 44px; height: 22px; appearance: none; background: rgba(255,255,255,0.1); border-radius: 20px; position: relative; cursor: pointer; transition: background 0.2s; flex-shrink: 0; }
.toggle:checked { background: #FF7A00; }
.toggle::after { content: ''; position: absolute; width: 18px; height: 18px; background: white; border-radius: 50%; top: 2px; left: 2px; transition: left 0.2s; box-shadow: 0 1px 3px rgba(0,0,0,0.3); }
.toggle:checked::after { left: 24px; }
.switch-label h6 { margin: 0; font-size: 0.85rem; font-weight: 600; color: rgba(255,255,255,0.8); }
.switch-label p { margin: 0; font-size: 0.75rem; color: rgba(255,255,255,0.3); }

.preview-img-box { width: 100%; height: 200px; border-radius: 16px; object-fit: cover; border: 1px solid rgba(255,255,255,0.08); display: block; margin-bottom: 16px; }
.btn-save { background: linear-gradient(135deg,#FF7A00,#FF4500); border: none; border-radius: 12px; padding: 13px 28px; color: #fff; font-size: 0.9rem; font-weight: 700; cursor: pointer; transition: all 0.2s; width: 100%; }
.btn-save:hover { transform: translateY(-2px); box-shadow: 0 10px 25px rgba(255,122,0,0.3); }
.btn-discard { display: block; text-align: center; margin-top: 10px; color: rgba(255,255,255,0.3); font-size: 0.82rem; text-decoration: none; }
.btn-discard:hover { color: rgba(255,255,255,0.6); }

.err-list { background: rgba(239,68,68,0.08); border: 1px solid rgba(239,68,68,0.2); border-radius: 12px; padding: 14px 18px; margin-bottom: 20px; }
.err-list li { color: #ef4444; font-size: 0.82rem; }

.image-upload-area { border: 2px dashed rgba(255,255,255,0.1); border-radius: 12px; padding: 20px; text-align: center; cursor: pointer; transition: all 0.2s; }
.image-upload-area:hover { border-color: rgba(255,122,0,0.3); }
.image-upload-area input { display: none; }
.image-upload-area label { cursor: pointer; display: block; }
</style>
@endsection

@section('content')
<div class="admin-wrap">

    @include('admin.partials.sidebar')

    <main class="admin-main">
        <a href="{{ route('admin.food-items') }}" class="back-btn"><i class="fa-solid fa-arrow-left"></i> Back to Menu</a>
        <h1 class="page-title">Edit <span>Menu Item</span></h1>
        <p class="page-sub">Update pricing, availability and details — goes live instantly.</p>

        @if($errors->any())
        <ul class="err-list">
            @foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach
        </ul>
        @endif

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="edit-grid">
                {{-- Left Column --}}
                <div>
                    <div class="form-card">
                        <h5>Item Details</h5>
                        <div class="f-group">
                            <label class="f-label">Restaurant *</label>
                            <select name="restaurant_id" class="f-input" required>
                                @foreach($restaurants as $rest)
                                <option value="{{ $rest->id }}" {{ old('restaurant_id', $product->restaurant_id) == $rest->id ? 'selected' : '' }}>{{ $rest->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="f-group">
                            <label class="f-label">Item Name</label>
                            <input type="text" name="name" class="f-input" value="{{ old('name', $product->name) }}" required>
                        </div>
                        <div class="f-row">
                            <div class="f-group">
                                <label class="f-label">Category</label>
                                <select name="category_id" class="f-select f-input" required>
                                    @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="f-group">
                                <label class="f-label">Prep Time (min)</label>
                                <input type="number" name="preparation_time" class="f-input" value="{{ old('preparation_time', $product->preparation_time ?? 25) }}" min="1">
                            </div>
                        </div>
                        <div class="f-group">
                            <label class="f-label">Description</label>
                            <textarea name="description" class="f-input f-textarea" rows="4">{{ old('description', $product->description) }}</textarea>
                        </div>
                    </div>

                    <div class="form-card">
                        <h5>Pricing & Stock</h5>
                        <div class="f-row">
                            <div class="f-group">
                                <label class="f-label">Price (PKR)</label>
                                <div class="price-input-wrap">
                                    <span class="price-prefix">Rs.</span>
                                    <input type="number" name="price" class="f-input price-field" value="{{ old('price', $product->price) }}" min="0" step="0.01" required>
                                </div>
                            </div>
                            <div class="f-group">
                                <label class="f-label">Sale Price (PKR)</label>
                                <div class="price-input-wrap">
                                    <span class="price-prefix" style="color:#22c55e;">Rs.</span>
                                    <input type="number" name="sale_price" class="f-input price-field" value="{{ old('sale_price', $product->sale_price) }}" min="0" step="0.01">
                                </div>
                            </div>
                        </div>
                        <div class="f-group">
                            <label class="f-label">Stock Quantity</label>
                            <input type="number" name="quantity" class="f-input" value="{{ old('quantity', $product->quantity) }}" min="0" required>
                        </div>
                    </div>

                    <div class="form-card">
                        <h5>Image</h5>
                        <div class="f-group">
                            <label class="f-label">Image URL (Recommended)</label>
                            <input type="url" name="image_url" id="imageUrlInput" class="f-input" value="{{ old('image_url', Str::startsWith($product->image ?? '', 'http') ? $product->image : '') }}" placeholder="https://...">
                        </div>
                        <div style="text-align:center;color:rgba(255,255,255,0.2);font-size:0.75rem;margin:8px 0;">— or upload a file —</div>
                        <div class="image-upload-area">
                            <label for="imageFile">
                                <i class="fa-solid fa-cloud-arrow-up" style="font-size:1.5rem;color:rgba(255,122,0,0.4);display:block;margin-bottom:8px;"></i>
                                <span style="font-size:0.8rem;color:rgba(255,255,255,0.3);">Click to upload image</span>
                            </label>
                            <input type="file" name="image" id="imageFile" accept="image/*">
                        </div>
                    </div>
                </div>

                {{-- Right Column --}}
                <div>
                    <div class="form-card" style="margin-bottom:16px;">
                        <h5>Live Preview</h5>
                        <img src="{{ $product->display_image }}" class="preview-img-box" id="previewImg" alt="{{ $product->name }}">
                        <div style="font-weight:700;color:#fff;font-size:0.95rem;margin-bottom:4px;">{{ $product->name }}</div>
                        <div style="font-size:0.8rem;color:rgba(255,122,0,0.8);font-weight:700;">Rs. {{ number_format($product->display_price, 0) }}</div>
                        @if($product->restaurant)
                        <div style="font-size:0.75rem;color:rgba(255,255,255,0.3);margin-top:4px;"><i class="fa-solid fa-store" style="margin-right:4px;color:#818cf8;"></i>{{ $product->restaurant->name }}</div>
                        @endif
                    </div>

                    <div class="form-card" style="margin-bottom:16px;">
                        <h5>Visibility</h5>
                        <div class="switch-row">
                            <input type="checkbox" name="is_active" id="isActive" class="toggle" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                            <label for="isActive" class="switch-label">
                                <h6>Live on Menu</h6>
                                <p>Visible to all customers</p>
                            </label>
                        </div>
                        <div class="switch-row">
                            <input type="checkbox" name="is_featured" id="isFeatured" class="toggle" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                            <label for="isFeatured" class="switch-label">
                                <h6>Featured Item</h6>
                                <p>Shown on homepage spotlight</p>
                            </label>
                        </div>
                    </div>

                    <div class="form-card">
                        <button type="submit" class="btn-save"><i class="fa-solid fa-cloud-arrow-up" style="margin-right:8px;"></i>Save Changes</button>
                        <a href="{{ route('admin.food-items') }}" class="btn-discard">Discard & Go Back</a>
                    </div>
                </div>
            </div>
        </form>
    </main>
</div>

<script>
document.getElementById('imageUrlInput').addEventListener('input', function() {
    if (this.value) {
        const img = document.getElementById('previewImg');
        img.src = this.value;
        img.onerror = () => img.src = '{{ $product->display_image }}';
    }
});
document.getElementById('imageFile').addEventListener('change', function() {
    if (this.files && this.files[0]) {
        const reader = new FileReader();
        reader.onload = e => document.getElementById('previewImg').src = e.target.result;
        reader.readAsDataURL(this.files[0]);
    }
});
</script>
@endsection
