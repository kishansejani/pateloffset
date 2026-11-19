<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    public const STATUSES = [
        'pending'    => 'Pending',
        'confirmed'  => 'Confirmed',
        'designing'  => 'Designing',
        'printing'   => 'Printing',
        'shipped'    => 'Shipped',
        'delivered'  => 'Delivered',
        'cancelled'  => 'Cancelled',
    ];

    protected $fillable = [
        'order_number', 'name', 'email', 'phone', 'company', 'gst_number', 'address', 'city', 'state',
        'pincode', 'notes', 'subtotal', 'design_charges', 'shipping', 'gst', 'total', 'payment_method',
        'payment_status', 'status', 'razorpay_order_id', 'razorpay_payment_id', 'razorpay_signature', 'paid_at',
    ];

    protected $casts = ['paid_at' => 'datetime'];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public static function generateNumber(): string
    {
        do {
            $number = 'PO'.now()->format('ymd').random_int(1000, 9999);
        } while (static::where('order_number', $number)->exists());

        return $number;
    }

    public function statusLabel(): string
    {
        return self::STATUSES[$this->status] ?? ucfirst($this->status);
    }
}
