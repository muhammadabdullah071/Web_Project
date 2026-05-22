<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrTable extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurant_id', 'table_number', 'qr_code_path', 'is_active'
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    /**
     * Automatically generate a live QR code image URL for this table.
     * When scanned, it routes the customer directly to the restaurant's menu with their table pre-assigned.
     */
    public function getQrImageUrlAttribute()
    {
        if (!$this->restaurant) {
            return null;
        }
        
        // Generate the exact deep link for this specific table
        $scanUrl = route('qr.scan', [
            'restaurantSlug' => $this->restaurant->slug,
            'tableNumber' => $this->table_number
        ]);

        // Use QuickChart API to generate a high-quality QR code image on the fly
        return 'https://quickchart.io/qr?text=' . urlencode($scanUrl) . '&size=400&margin=2&centerImageUrl=https://cdn-icons-png.flaticon.com/512/3448/3448011.png';
    }
}
