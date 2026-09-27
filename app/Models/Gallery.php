<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = [
        'image_url',
        'title',
        'description',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public static function boot()
    {
        parent::boot();
        
        // Default order by sort_order
        static::addGlobalScope('ordered', function ($query) {
            $query->orderBy('sort_order')->orderBy('created_at');
        });
    }
}
