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

    public function tier()
    {
        return $this->hasOne(Param::class, 'id', 'level_id')->where('type', 'LEVPOS');
    }

    public function scopeDep($query)
    {
        return $query->where('type', 'DEP');
    }

    public function scopeLev($query)
    {
        return $query->where('type', 'LEVPOS')->orderBy('level');
    }
}
