<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiderAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'rider_id', 'status', 'lat', 'lng'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function rider()
    {
        return $this->belongsTo(User::class, 'rider_id');
    }
}
