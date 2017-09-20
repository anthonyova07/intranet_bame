<?php

namespace Bame\Models\Process\ClosingCost;

use Illuminate\Database\Eloquent\Model;

class Param extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intprccopa';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;
}
