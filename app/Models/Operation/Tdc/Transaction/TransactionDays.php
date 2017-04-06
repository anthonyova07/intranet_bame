<?php

namespace Bame\Models\Operation\Tdc\Transaction;

use Illuminate\Database\Eloquent\Model;

use Bame\Models\Operation\Tdc\Description;
use Bame\Models\Customer\Product\CreditCard;

class TransactionDays extends Model
{
    protected $connection = 'itc';

    protected $table = 'trnhist00';

    protected $primaryKey = 'numtc_atrn';

    public $incrementing = false;

    public $timestamps = false;

    public function getCreditCard()
    {
        return clear_str($this->numtc_atrn);
    }

    public function getDescription()
    {
        return cap_str($this->destr_atrn);
    }

    public function getCurrency()
    {
        return $this->moned_atrn;
    }

    public function getAmount()
    {
        return $this->valtr_atrn;
    }

    public function getProcessDate($formatted = true)
    {
        if ($formatted) {
            return $this->format_date($this->fecpr_atrn);
        } else {
            return $this->fecpr_atrn;
        }
    }

    public function getTransactionDate($formatted = true)
    {
        if ($formatted) {
            return $this->format_date($this->fectr_atrn, 'dmy');
        } else {
            return $this->fectr_atrn;
        }
    }

    public function creditcard()
    {
        return $this->hasOne(CreditCard::class, 'tcact_mtar', 'numtc_atrn');
    }

    public function transaction_type()
    {
        return $this->hasOne(Description::class, 'codig_desc', 'codtr_atrn')->where('prefi_desc', 'SAT_CODTR');
    }

    public function transaction_concep()
    {
        $this->codco_atrn =  str_pad($this->codco_atrn, 3, '0', STR_PAD_LEFT);
        return $this->hasOne(Description::class, 'codig_desc', 'codco_atrn')->where('prefi_desc', 'SAT_CONCEP');
    }

    public function format_date($date, $from = 'ymd')
    {
        if ($from == 'ymd') {
            $y = substr($date, 0, 4);
            $m = substr($date, 4, 2);
            $d = substr($date, 6, 2);
        } else if ($from == 'dmy') {
            if (strlen($date) == 8) {
                $d = substr($date, 0, 2);
                $m = substr($date, 2, 2);
                $y = substr($date, 4, 4);
            } else if (strlen($date) == 7) {
                $d = '0' . substr($date, 0, 1);
                $m = substr($date, 1, 2);
                $y = substr($date, 3, 4);
            } else {
                $d = '';
                $m = '';
                $y = '';
            }
        }

        return $d . '/' . $m . '/' . $y;
    }
}
