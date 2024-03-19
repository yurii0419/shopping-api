<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'street',
        'city',
        'province',
        'zip_code',
        'is_deleted',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
