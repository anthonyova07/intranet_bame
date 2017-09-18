<?php

namespace Bame\Models\Marketing\Lottery;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $connection = 'sqlsrv_bi';

    protected $table = 'baseBoletos';

    protected $primaryKey = 'customerID';

    public $incrementing = false;

    public $timestamps = false;
}
