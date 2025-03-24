<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['rating_id', 'comment', 'published_at'];


    public function rating()
    {
        return $this->belongsTo(Rating::class);
    }

    public function publish()
    {
        $this->update(['published_at' => now()]);
    }

    public function isPublished()
    {
        return !is_null($this->published_at);
    }

    public function getStatusAttribute()
    {
        if ($this->deleted_at) {
            return 'deleted';
        }
        if ($this->published_at) {
            return 'published';
        }
        return 'pending';
    }
}
