<?php

namespace App\Domain\Client\Zone\Sub;

use Illuminate\Database\Eloquent\Model;

class SubZoneConfiguration extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'sub_zone_id',
        'columns',
        'block_columns'
    ];

    public function sub_zone()
    {
        return $this->belongsTo(SubZone::class,'sub_zone_id','id');
    }
}
