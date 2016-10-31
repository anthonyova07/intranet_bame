<?php

namespace Bame\Models\IB\Transaction;

use Illuminate\Database\Eloquent\Model;

use Bame\Models\IB\Transaction\Account\Currency;

class Transaction extends Model
{
    protected $connection = 'sqlsrv_ibtrxs';

    protected $table = 'Transactions';

    protected $primaryKey = 'transactionID';

    public $incrementing = false;

    public $timestamps = false;

    public function trnTypeCurrency()
    {
        return $this->belongsTo(TransactionTypeCurrency::class, 'trnTypeCurrencyID')->with('transactionType');
    }

    public function currencyFrom()
    {
        return $this->belongsTo(Currency::class, 'accountFromCurrency');
    }

    public function currencyTo()
    {
        return $this->belongsTo(Currency::class, 'accountToCurrency');
    }

    public function transactionExt()
    {
        return $this->belongsTo(TransactionExt::class, 'transactionID')->with(['customer', 'bank']);
    }
}
