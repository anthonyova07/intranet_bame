<?php

namespace Bame\Models\HumanResource\Employee;

use Illuminate\Database\Eloquent\Model;

class Param extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intrhemppa';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;

    protected $dates = [];

    public function department()
    {
        return $this->belongsTo(Param::class, 'dep_id', 'id')->where('type', 'DEP');
    }
}
