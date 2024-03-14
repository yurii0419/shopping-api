<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Onboarding extends Model
{
    use HasFactory;

    protected $table = 'onboarding';

    protected $fillable = [
        'preferences',
        'styles'
    ];
}
