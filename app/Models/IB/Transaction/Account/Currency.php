<?php

namespace Bame\Models\IB\Transaction\Account;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $connection = 'sqlsrv_ibtrxs';

    protected $table = 'Currencies';

    protected $primaryKey = 'ID';

    public $incrementing = false;

    public $timestamps = false;
}
