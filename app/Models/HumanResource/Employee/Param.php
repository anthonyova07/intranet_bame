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
}
