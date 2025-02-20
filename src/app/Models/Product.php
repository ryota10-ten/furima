<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name','brand','img','category_id','condition_id','price','detail'];

    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }

    public function scopeKeywordSearch($query, $keyword)
    {
        if (!empty($keyword))
        {
            $query->where('name', 'like', '%' . $keyword . '%');
        }
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    
    public function listings()
    {
        return $this->hasMany(Listing::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'listings');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function isLikedBy($userId)
    {
        return $this->favorites->where('user_id', $userId)->isNotEmpty();
    }

    public function favoriteUsers()
    {
        return $this->belongsToMany(User::class, 'favorites', 'product_id', 'user_id');
    }
    
    public function listingUsers()
    {
        return $this->belongsToMany(User::class, 'listings', 'product_id', 'user_id');
    }

    public function orderUsers()
    {
        return $this->belongsToMany(User::class, 'orders', 'product_id', 'user_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    protected $table = 'products';
}
