<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'owner_user_id',
        'title',
        'description',
        'occasion',
        'sizes',
        'condition',
        'rent_price',
        'buy_price',
        'listing_mode',
        'network_image_urls',
        'local_image_paths',
        'rental_blocked_dates',
        'status',
        'is_rented_out',
        'is_sold',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'sizes' => 'array',
        'rent_price' => 'float',
        'buy_price' => 'float',
        'network_image_urls' => 'array',
        'local_image_paths' => 'array',
        'rental_blocked_dates' => 'array',
        'is_rented_out' => 'boolean',
        'is_sold' => 'boolean',
    ];
}
