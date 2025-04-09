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

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function averageRating()
    {
        return $this->ratings()->avg('rating') ?? 0;
    }

    public function canRate($customer_id)
    {
        $completedOrders = $this->orders()
            ->where('customer_id', $customer_id)
            ->where('status', 'completed')
            ->whereHas('products', function ($query) {
                $query->where('product_id', $this->id);
            })
            ->get();

        if ($completedOrders->isEmpty()) {
            return false;
        }

        $existingRating = Rating::where('product_id', $this->id)
            ->where('customer_id', $customer_id)
            ->whereIn('order_id', $completedOrders->pluck('id'))
            ->exists();

        return !$existingRating;
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
