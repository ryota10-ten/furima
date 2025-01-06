<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name','img','category_id','condition_id','price','detail'];

    public function condition()
    {
        return $this->belongsTo(Condition::class);
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

    protected $table = 'products';
}
