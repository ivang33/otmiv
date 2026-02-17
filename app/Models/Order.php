<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_date',
        'total_price',
        'tracking_code',
        'status_id',
        'user_id',
        'pickup_point_id',
    ];

    protected $casts = [
        'order_date' => 'date',
        'total_price' => 'decimal:2',
    ];

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pickupPoint()
    {
        return $this->belongsTo(PickupPoint::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
