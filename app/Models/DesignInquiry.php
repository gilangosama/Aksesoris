<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class DesignInquiry extends Model
{
    protected $table = 'design_inquiries';

    protected $fillable = [
        'user_id',
        'reference_design',
        'type',
        'finish',
        'chain_style_id',
        'chain_size',
        'style',
        'budget',
        'material',
        'description',
        'design_snapshot',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function chainStyle()
    {
        return $this->belongsTo(ChainStyle::class);
    }

    public function charms()
    {
        return $this->belongsToMany(Charm::class, 'charm_design_inquiry')
                    ->withPivot(['charm_position_x', 'charm_position_y'])
                    ->withTimestamps();
    }

    public function charmDesignItems()
    {
        return $this->hasMany(CharmDesignInquiry::class)->orderBy('id');
    }
}


