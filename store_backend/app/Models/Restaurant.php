<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id', 'name', 'slug', 'description', 'image', 'banner', 
        'address', 'phone', 'email', 'rating', 'delivery_time', 'min_order', 'is_active'
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function getDisplayImageAttribute()
    {
        if (!$this->image || str_contains($this->image, 'via.placeholder') || str_contains($this->image, 'ui-avatars')) {
            return 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?q=80&w=1000'; // Global Premium Fallback
        }

        if (Str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }
        return asset('storage/' . $this->image);
    }


    public function getDisplayBannerAttribute()
    {
        if (!$this->banner) {
            return 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=2000'; // Fallback
        }
        if (Str::startsWith($this->banner, ['http://', 'https://'])) {
            return $this->banner;
        }
        return asset('storage/' . $this->banner);
    }
}
