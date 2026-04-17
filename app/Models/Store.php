<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'name',
        'description',
        'logo_url',
        'banner_url',
        'rating',
        'review_count',
        'city',
        'location',
        'contact_email',
        'contact_phone',
    ];

    protected $casts = [
        'rating' => 'float',
        'review_count' => 'integer',
    ];
}
