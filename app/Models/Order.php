<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total',
        'status',
    ];

    protected static function booted()
    {
        static::creating(function ($order) {
            if (empty($order->order_number)) {
                do {
                    $number = str_pad(random_int(0, 999999999), 9, '0', STR_PAD_LEFT);
                } while (self::where('order_number', $number)->exists());
                $order->order_number = $number;
            }
        });
    }

    public function payment()
    {
        return $this->hasOne(\App\Models\Payment::class);
    }

    public function orderItems()
    {
        return $this->hasMany(\App\Models\OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function invoice()
    {
        return $this->hasOne(\App\Models\Invoice::class);
    }
}
