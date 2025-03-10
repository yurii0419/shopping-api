<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'subcategory_id',
        'sub_subcategory_id',
        'user_id',
        'shop_id',
        'product_code',
        'product_name',
        'product_description',
        'product_brand',
        'slug',
        'price',
        'quantity',
        'size',
        'style',
        'color',
        'condition',
        'keyword',
        'status',
        'image',
        'like',
        'share',
        'shipping_fee'
    ];

    protected $casts = [
        'keyword' => 'array',
        'size' => 'array'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class, 'subcategory_id');
    }
    public function color()
    {
        return $this->belongsTo(Color::class, 'color_id');
    }
    public function style()
    {
        return $this->belongsTo(Style::class, 'style_id');
    }
    public function condition()
    {
        return $this->belongsTo(Condition::class, 'condition_id');
    }

    public function subSubCategory()
    {
        return $this->belongsTo(SubsubCategory::class, 'sub_subcategory_id');
    }

    public function measurements()
    {
        return $this->hasMany(Measurement::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function shop()
    {
        return $this->belongsTo(SellerShop::class, 'shop_id');
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function discounts()
    {
        return $this->hasMany(Discount::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function offers()
    {
        return $this->hasMany(MakeOffer::class);
    }

    public function wishlists()
    {
        return $this->belongsToMany(User::class, 'wishlists')->withTimestamps();;
    }

    public function reviews()
    {
        return $this->morphToMany(Review::class, 'reviewable');
    }

    public function likers()
    {
        return $this->belongsToMany(User::class, 'likes', 'product_id', 'user_id')->withTimestamps();
    }

    public function markAsSold()
    {
        $this->status = true;
        $this->save();

        return $this;
    }

    public function shipping()
    {
        return $this->hasMany(Shipping::class);
    }
}
