<?php

namespace Bame\Models\Process\ClosingCost;

use Illuminate\Database\Eloquent\Model;

class ClosingCost extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intclocost';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;
}
