<?php

namespace Bame\Models\IB\Transaction;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $connection = 'sqlsrv_ibtrxs';

    protected $table = 'Banks';

    protected $primaryKey = 'ID';

    public $incrementing = false;

    public $timestamps = false;
}
