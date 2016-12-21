<?php

namespace Bame\Models\HumanResource\Calendar;

use Illuminate\Database\Eloquent\Model;

class Date extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intcaldate';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;
}
