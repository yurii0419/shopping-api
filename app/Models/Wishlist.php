<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{


    use HasFactory;
    protected $fillable =[
        'user_id',
        'product_id',
        'product_name',
        'price',
        'like',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_wishlist');
    }


}
