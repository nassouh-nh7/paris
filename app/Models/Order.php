<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'dress_id',
        'dress_title',
        'image_url',
        'kind',
        'total',
        'status',
        'rental_start',
        'rental_end',
        'placed_at',
    ];

    protected $casts = [
        'total' => 'float',
        'rental_start' => 'datetime',
        'rental_end' => 'datetime',
        'placed_at' => 'datetime',
    ];
}
