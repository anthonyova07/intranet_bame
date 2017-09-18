<?php

namespace Bame\Models\Marketing\Lottery;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $connection = 'sqlsrv_bi';

    protected $table = 'baseClientes';

    // protected $primaryKey = '...';

    public $incrementing = false;

    public $timestamps = false;
}
