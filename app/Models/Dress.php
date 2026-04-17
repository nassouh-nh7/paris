<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dress extends Model
{
    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'title',
        'description',
        'image_urls',
        'sizes',
        'colors',
        'occasion',
        'condition',
        'seller_type',
        'rent_price',
        'buy_price',
        'listing_mode',
        'store_id',
        'individual_seller_name',
        'seller_email',
        'seller_phone',
        'seller_location',
        'popularity_score',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'image_urls' => 'array',
        'sizes' => 'array',
        'colors' => 'array',
        'rent_price' => 'float',
        'buy_price' => 'float',
        'popularity_score' => 'integer',
    ];
}
