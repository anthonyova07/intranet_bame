<?php

namespace Bame\Models\IB\Transaction;

use Illuminate\Database\Eloquent\Model;

class TransactionType extends Model
{
    protected $connection = 'sqlsrv_ibtrxs';

    protected $table = 'TransactionTypes';

    protected $primaryKey = 'transactionTypeID';

    public $incrementing = false;

    public $timestamps = false;
}
