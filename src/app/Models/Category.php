<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['category'];

    protected $table = 'categories';

    public function products()
    {
        return $this->belongsToMany(Product::class, 'category_product');
    }
}
