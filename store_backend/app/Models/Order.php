<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'restaurant_id', 'order_number', 'subtotal', 'shipping', 'platform_fee', 'total', 'status',
        'payment_method', 'payment_status', 'first_name', 'last_name', 'email',
        'phone', 'address', 'city', 'state', 'zip_code', 'notes', 'delivery_fee', 'tax_amount', 'order_type'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public static function generateOrderNumber()
    {
        return 'PE-' . strtoupper(uniqid());
    }
}
