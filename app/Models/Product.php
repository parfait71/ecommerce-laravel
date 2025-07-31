<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'category_id',
    ];

    public function images()
    {
        return $this->hasMany(\App\Models\ProductImage::class);
    }

    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class);
    }

    // ✅ Relation avec les commandes (many-to-many avec pivot 'quantity')
    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot('quantity');
    }
}
