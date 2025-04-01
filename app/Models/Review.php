<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $primaryKey = 'review_id';

    protected $fillable = [
        'customer_id',
        'orderinfo_id',
        'item_id',
        'rating',
        'review_text',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function images()
    {
        return $this->hasMany(ReviewImage::class, 'review_id');
    }
}
