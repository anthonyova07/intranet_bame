<?php

namespace Bame\Models\IB\Transaction;

use Illuminate\Database\Eloquent\Model;

class TransactionTypeCurrency extends Model
{
    protected $connection = 'sqlsrv_ibtrxs';

    protected $table = 'TransactionTypesCurrencies';

    protected $primaryKey = 'trnTypeCurrencyID';

    public $incrementing = false;

    public $timestamps = false;

    public function transactionType()
    {
        return $this->belongsTo(TransactionType::class, 'transactionTypeID');
    }
}
