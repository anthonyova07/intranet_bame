<?php

namespace Bame\Models\IB\Transaction;

use Illuminate\Database\Eloquent\Model;

use Bame\Models\IB\Customer\Customer;

class TransactionExt extends Model
{
    protected $connection = 'sqlsrv_ibtrxs';

    protected $table = 'TransactionsExt';

    protected $primaryKey = 'transactionID';

    public $incrementing = false;

    public $timestamps = false;

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customerID');
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bankID');
    }
}
