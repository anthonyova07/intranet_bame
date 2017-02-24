<?php

namespace Bame\Models\Process\Request;

use Illuminate\Database\Eloquent\Model;

class ProcessRequestStatus extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intreqpres';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;
}
