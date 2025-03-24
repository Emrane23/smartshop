<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'order_id', 'product_id', 'rating'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function comment()
    {
        return $this->hasOne(Comment::class);
    }

    public function publishedComments()
    {
        return $this->hasOne(Comment::class)->whereNotNull('published_at');
    }
}
