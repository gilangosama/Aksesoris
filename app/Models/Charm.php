<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Charm extends Model
{
    protected $table = 'charms';

    protected $fillable = [
        'name',
        'image',
        'description',
        'size',
        'price_add',
        'stock',
        'space_required',
        'category',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price_add' => 'decimal:2',
    ];
}
