<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DesignInquiry;
use App\Models\PickupLocation;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'order_number',
        'user_id',
        'address_id',
        'pickup_location_id',
        'delivery_method',
        'amount',
        'total_price',
        'status',
        'customer_name',
        'customer_email',
        'customer_phone',
        'address',
        'payment_method',
        'transaction_id',
        'tracking_number',
        'snap_token',
        'is_gift',
        'gift_message',
        'design_inquiry_id',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function addressRecord()
    {
        return $this->belongsTo(Address::class, 'address_id');
    }

    public function pickupLocation()
    {
        return $this->belongsTo(PickupLocation::class, 'pickup_location_id');
    }

    public function designInquiry()
    {
        return $this->belongsTo(DesignInquiry::class, 'design_inquiry_id');
    }

    public function rating()
    {
        return $this->hasOne(OrderRating::class);
    }
}
