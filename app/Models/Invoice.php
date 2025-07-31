<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'pdf_path',
        'invoice_number',
    ];

    protected static function booted()
    {
        static::creating(function ($invoice) {
            if (empty($invoice->invoice_number)) {
                $next = self::max('id') + 1;
                $invoice->invoice_number = '#' . $next;
            }
        });
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
