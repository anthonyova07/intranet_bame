<?php

namespace Bame\Models\HumanResource\Calendar;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intcalgrou';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;
}
