<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReviewImage extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'review_images';

    protected $fillable = [
        'review_id',
        'image_path',
    ];

    public function review()
    {
        return $this->belongsTo(Review::class, 'review_id');
    }
}
