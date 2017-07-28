<?php

namespace Bame\Models\HumanResource\Employee;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intrhemplo';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;

    protected $dates = [];

    public function department()
    {
        return $this->hasOne(Param::class, 'id', 'id_dep');
    }

    public function position()
    {
        return $this->hasOne(Param::class, 'id', 'id_pos');
    }

    public function supervisor()
    {
        return $this->hasOne(Param::class, 'id', 'id_sup');
    }
}
