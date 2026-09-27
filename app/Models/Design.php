<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Design extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'type',
        'style',
        'material',
        'featured',
        'client_pick',
        'trending',
        'limited',
        'image',
        'images',
        'is_active',
    ];

    protected $casts = [
        'images' => 'array',
        'featured' => 'boolean',
        'client_pick' => 'boolean',
        'trending' => 'boolean',
        'limited' => 'boolean',
        'is_active' => 'boolean',
    ];
}
