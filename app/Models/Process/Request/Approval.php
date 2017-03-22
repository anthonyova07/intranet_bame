<?php

namespace Bame\Models\Process\Request;

use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intreqprap';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;

    protected $dates = ['approvdate'];
}
