<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Customer extends Model implements Searchable
{
    use HasFactory;
    protected $table = 'customer';
    protected $primaryKey = 'customer_id';
    public $timestamps = false;

    protected $fillable = [
        'user_id', // ✅ Add this line
        'title',
        'fname',
        'lname',
        'addressline',
        'town',
        'phone',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviews()
{
    return $this->hasMany(Review::class);
}

public function getSearchResult(): SearchResult
     {
        $url = route('customers.show', $this->customer_id);
     
         return new SearchResult(
            $this,
            $this->fname . " ". $this->lname,
            $url
         );
     }
}
