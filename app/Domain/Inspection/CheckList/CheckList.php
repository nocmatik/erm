<?php

namespace App\Domain\Inspection\CheckList;

use App\App\Traits\Model\Sluggable;
use App\Domain\Client\CheckPoint\Type\CheckPointType;
use App\Domain\Inspection\CheckList\Module\CheckListModule;
use Illuminate\Database\Eloquent\Model;

class CheckList extends Model
{

    use Sluggable;

    public $timestamps = false;

    protected $fillable = [
        'check_point_type_id','slug','name'
    ];

    public function check_point_type()
    {
        return $this->belongsTo(CheckPointType::class,'check_point_type_id','id');
    }

    public function modules()
    {
        return $this->hasMany(CheckListModule::class,'check_list_id','id');
    }
}
