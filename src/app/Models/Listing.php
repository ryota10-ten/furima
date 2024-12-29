<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = ['profile_id','product_id',];

    protected $table = 'listings';

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}
