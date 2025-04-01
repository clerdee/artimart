<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemImage extends Model
{
    use HasFactory;
    use SoftDeletes;

    
    protected $table = 'item_images'; 

    protected $primaryKey = 'itemimg_id'; 

    protected $fillable = [
        'item_id',
        'image_path',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'item_id');
    }
}
