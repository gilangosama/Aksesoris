<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CharmDesignInquiry extends Model
{
    protected $table = 'charm_design_inquiry';

    protected $fillable = [
        'design_inquiry_id',
        'charm_id',
        'charm_position_x',
        'charm_position_y',
    ];

    public function designInquiry()
    {
        return $this->belongsTo(DesignInquiry::class);
    }

    public function charm()
    {
        return $this->belongsTo(Charm::class);
    }
}
