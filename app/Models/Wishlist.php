<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{

    protected $table = 'wishlist';

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
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
