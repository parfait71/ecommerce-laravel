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

    // ✅ Relation avec la catégorie
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // ✅ Relation avec les commandes (many-to-many avec pivot 'quantity' et 'price')
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_product')
                    ->withPivot('quantity', 'price')
                    ->withTimestamps();
    }
}
