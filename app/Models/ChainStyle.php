<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChainStyle extends Model
{
    protected $table = 'chain_styles';

    protected $fillable = [
        'customizable_jewelry_id',
        'name',
        'finish', // silver or gold
        'image',
        'description',
        'sizes',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sizes' => 'array',
    ];

    public function jewelry()
    {
        return $this->belongsTo(CustomizableJewelry::class, 'customizable_jewelry_id');
    }
}
