<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomizableJewelry extends Model
{
    protected $table = 'customizable_jewelry';

    protected $fillable = [
        'type',
        'label',
        'icon',
        'image',
        'description',
        'base_price',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'base_price' => 'decimal:2',
    ];

    public function chainStyles()
    {
        return $this->hasMany(ChainStyle::class, 'customizable_jewelry_id');
    }

    public function charms()
    {
        return $this->hasMany(Charm::class, 'customizable_jewelry_id');
    }
}
