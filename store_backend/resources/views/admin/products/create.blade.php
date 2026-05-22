@extends('layouts.app')
@section('title', 'Add Menu Item - FoodDash Admin')

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
.f-input { width: 100%; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 12px; padding: 12px 16px; color: #fff; font-size: 0.9rem; transition: all 0.2s; outline: none; font-family: 'Inter', sans-serif; }
.f-input:focus { border-color: rgba(255,122,0,0.5); background: rgba(255,122,0,0.03); box-shadow: 0 0 0 3px rgba(255,122,0,0.08); }
.f-input::placeholder { color: rgba(255,255,255,0.2); }
.f-input option { background: #111; }
.f-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.price-input-wrap { position: relative; }
.price-prefix { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: rgba(255,122,0,0.7); font-weight: 700; font-size: 0.85rem; pointer-events: none; }
.price-field { padding-left: 42px !important; }
.switch-row { display: flex; align-items: center; gap: 14px; padding: 14px 0; border-bottom: 1px solid rgba(255,255,255,0.04); }
.switch-row:last-child { border-bottom: none; }
.toggle { width: 44px; height: 22px; appearance: none; background: rgba(255,255,255,0.1); border-radius: 20px; position: relative; cursor: pointer; transition: background 0.2s; flex-shrink: 0; }
.toggle:checked { background: #FF7A00; }
.toggle::after { content: ''; position: absolute; width: 18px; height: 18px; background: white; border-radius: 50%; top: 2px; left: 2px; transition: left 0.2s; }
.toggle:checked::after { left: 24px; }
.switch-label h6 { margin: 0; font-size: 0.85rem; font-weight: 600; color: rgba(255,255,255,0.8); }
.switch-label p { margin: 0; font-size: 0.75rem; color: rgba(255,255,255,0.3); }
.preview-box { background: rgba(255,255,255,0.02); border: 2px dashed rgba(255,255,255,0.08); border-radius: 16px; height: 200px; display: flex; align-items: center; justify-content: center; flex-direction: column; gap: 8px; margin-bottom: 16px; overflow: hidden; }
.preview-box img { width: 100%; height: 100%; object-fit: cover; display: none; border-radius: 14px; }
.preview-placeholder { text-align: center; color: rgba(255,255,255,0.2); }
.preview-placeholder i { font-size: 2rem; display: block; margin-bottom: 8px; }
.preview-placeholder span { font-size: 0.75rem; }
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
        <a href="{{ route('admin.food-items') }}" class="back-btn"><i class="fa-solid fa-arrow-left"></i> Back to Menu</a>
        <h1 class="page-title">Add <span>Menu Item</span></h1>
        <p class="page-sub">Add a new dish to the platform menu — it goes live instantly.</p>

        @if($errors->any())
        <ul class="err-list">
            @foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach
        </ul>
        @endif

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="edit-grid">
                {{-- Left --}}
                <div>
                    <div class="form-card">
                        <h5>Item Details</h5>
                        <div class="f-group">
                            <label class="f-label">Restaurant *</label>
                            <select name="restaurant_id" class="f-input" required>
                                <option value="">— Select Restaurant —</option>
                                @foreach($restaurants as $rest)
                                <option value="{{ $rest->id }}" {{ old('restaurant_id') == $rest->id ? 'selected' : '' }}>{{ $rest->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="f-group">
                            <label class="f-label">Item Name *</label>
                            <input type="text" name="name" class="f-input" value="{{ old('name') }}" placeholder="e.g. Signature Smash Burger" required>
                        </div>
                        <div class="f-row">
                            <div class="f-group">
                                <label class="f-label">Category *</label>
                                <select name="category_id" class="f-input" required>
                                    <option value="">— Select Category —</option>
                                    @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="f-group">
                                <label class="f-label">Prep Time (min)</label>
                                <input type="number" name="preparation_time" class="f-input" value="{{ old('preparation_time', 20) }}" min="1">
                            </div>
                        </div>
                        <div class="f-group">
                            <label class="f-label">Description</label>
                            <textarea name="description" class="f-input" rows="4" style="resize:vertical;" placeholder="Describe this dish...">{{ old('description') }}</textarea>
                        </div>
                    </div>

                    <div class="form-card">
                        <h5>Pricing & Stock</h5>
                        <div class="f-row">
                            <div class="f-group">
                                <label class="f-label">Price (PKR) *</label>
                                <div class="price-input-wrap">
                                    <span class="price-prefix">Rs.</span>
                                    <input type="number" name="price" class="f-input price-field" value="{{ old('price') }}" min="0" step="0.01" placeholder="0" required>
                                </div>
                            </div>
                            <div class="f-group">
                                <label class="f-label">Sale Price (PKR)</label>
                                <div class="price-input-wrap">
                                    <span class="price-prefix" style="color:#22c55e;">Rs.</span>
                                    <input type="number" name="sale_price" class="f-input price-field" value="{{ old('sale_price') }}" min="0" step="0.01" placeholder="Optional">
                                </div>
                            </div>
                        </div>
                        <div class="f-group">
                            <label class="f-label">Stock Quantity *</label>
                            <input type="number" name="quantity" class="f-input" value="{{ old('quantity', 50) }}" min="0" required>
                        </div>
                    </div>

                    <div class="form-card">
                        <h5>Image</h5>
                        <div class="f-group">
                            <label class="f-label">Image URL (Recommended)</label>
                            <input type="url" name="image_url" id="imgUrlInput" class="f-input" value="{{ old('image_url') }}" placeholder="https://images.unsplash.com/...">
                        </div>
                        <div style="text-align:center;color:rgba(255,255,255,0.2);font-size:0.75rem;margin:8px 0;">— or —</div>
                        <div class="f-group">
                            <label class="f-label">Upload File</label>
                            <input type="file" name="image" id="imgFileInput" class="f-input" accept="image/*" style="padding:10px;">
                        </div>
                    </div>
                </div>

                {{-- Right --}}
                <div>
                    <div class="form-card" style="margin-bottom:16px;">
                        <h5>Preview</h5>
                        <div class="preview-box" id="previewBox">
                            <img id="previewImg" src="" alt="Preview">
                            <div class="preview-placeholder" id="previewPlaceholder">
                                <i class="fa-solid fa-utensils"></i>
                                <span>Image preview</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-card" style="margin-bottom:16px;">
                        <h5>Visibility</h5>
                        <div class="switch-row">
                            <input type="checkbox" name="is_active" id="isActive" class="toggle" checked>
                            <label for="isActive" class="switch-label">
                                <h6>Live on Menu</h6>
                                <p>Visible to customers</p>
                            </label>
                        </div>
                        <div class="switch-row">
                            <input type="checkbox" name="is_featured" id="isFeatured" class="toggle">
                            <label for="isFeatured" class="switch-label">
                                <h6>Featured</h6>
                                <p>Shown on homepage</p>
                            </label>
                        </div>
                    </div>

                    <div class="form-card">
                        <button type="submit" class="btn-save"><i class="fa-solid fa-plus" style="margin-right:8px;"></i>Add to Menu</button>
                        <a href="{{ route('admin.food-items') }}" class="btn-discard">Cancel & Go Back</a>
                    </div>
                </div>
            </div>
        </form>
    </main>
</div>

<script>
document.getElementById('imgUrlInput').addEventListener('input', function() {
    showPreview(this.value);
});
document.getElementById('imgFileInput').addEventListener('change', function() {
    if (this.files && this.files[0]) {
        const reader = new FileReader();
        reader.onload = e => showPreview(e.target.result);
        reader.readAsDataURL(this.files[0]);
    }
});
function showPreview(src) {
    const img = document.getElementById('previewImg');
    const ph = document.getElementById('previewPlaceholder');
    if (src) {
        img.src = src;
        img.style.display = 'block';
        ph.style.display = 'none';
        img.onerror = () => { img.style.display='none'; ph.style.display='block'; };
    } else {
        img.style.display = 'none';
        ph.style.display = 'block';
    }
}
</script>
@endsection
