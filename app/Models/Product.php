<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    const DEFAULT_IMAGE = 'img/products/default-product-image.jpg';

    protected $fillable = ['name', 'image', 'description', 'price', 'discount', 'stock'];

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_items')
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }

    public function getImageAttribute($value)
    {
        return $value ?? static::DEFAULT_IMAGE;
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
