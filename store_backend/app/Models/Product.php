<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurant_id', 'category_id', 'name', 'slug', 'description', 'price', 
        'sale_price', 'quantity', 'image', 'is_featured', 'is_active', 
        'is_available', 'preparation_time'
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getDisplayPriceAttribute()
    {
        return $this->sale_price ?: $this->price;
    }

    public function getDisplayImageAttribute()
    {
        $name = strtolower($this->name);
        
        // Premium verified themed image mapping for products
        $themedImages = [
            'zinger' => 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?q=80&w=1000', // Burger
            'burger' => 'https://images.unsplash.com/photo-1550547660-d9450f859349?q=80&w=1000',
            'pizza' => 'https://images.unsplash.com/photo-1513104890138-7c749659a591?q=80&w=1000',
            'sushi' => 'https://images.unsplash.com/photo-1579871494447-9811cf80d66c?q=80&w=1000',
            'mutton' => 'https://images.unsplash.com/photo-1603360946369-dc9bb6258143?q=80&w=1000',
            'handi' => 'https://images.unsplash.com/photo-1512058560566-42724afbc2aa?q=80&w=1000',
            'grill' => 'https://images.unsplash.com/photo-1544148103-0773bf10d330?q=80&w=1000',
            'steak' => 'https://images.unsplash.com/photo-1600891964599-f61ba0e24092?q=80&w=1000',
            'beef' => 'https://images.unsplash.com/photo-1534422298391-e4f8c170db0f?q=80&w=1000',
            'waffle' => 'https://images.unsplash.com/photo-1551024506-0bccd828d307?q=80&w=1000',
            'chinese' => 'https://images.unsplash.com/photo-1525755662778-989d0524087e?q=80&w=1000',
            'chicken' => 'https://images.unsplash.com/photo-1598515214211-89d3c73ae83b?q=80&w=1000',
            'seafood' => 'https://images.unsplash.com/photo-1615141982883-c7ad0e69fd62?q=80&w=1000',
            'fish' => 'https://images.unsplash.com/photo-1519708227418-c8fd9a32b7a2?q=80&w=1000',
        ];

        foreach ($themedImages as $key => $url) {
            if (str_contains($name, $key)) {
                return $url;
            }
        }

        if (!$this->image || str_contains($this->image, 'via.placeholder') || str_contains($this->image, 'ui-avatars')) {
            // High quality fallback based on category
            $fallbacks = [
                'burgers' => 'https://images.unsplash.com/photo-1571091718767-18b5b1457add?q=80&w=1000',
                'pizza' => 'https://images.unsplash.com/photo-1513104890138-7c749659a591?q=80&w=1000',
                'chinese' => 'https://images.unsplash.com/photo-1525755662778-989d0524087e?q=80&w=1000',
                'desi' => 'https://images.unsplash.com/photo-1589187151032-573a91317445?q=80&w=1000',
                'desserts' => 'https://images.unsplash.com/photo-1551024506-0bccd828d307?q=80&w=1000',
            ];

            return $fallbacks[$this->category->slug ?? 'burgers'] ?? 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=1000';
        }

        if (Str::startsWith($this->image, 'http')) {
            return $this->image;
        }

        return asset('storage/' . $this->image);
    }
}
