<?php

namespace Bame\Models\Customer\Product;

use Illuminate\Database\Eloquent\Model;

class LoanMoneyMarket extends Model
{
    protected $connection = 'ibs';

    protected $table = 'deals';

    protected $primaryKey = 'deaacc';

    public $incrementing = false;

    public $timestamps = false;

    public function getNumber()
    {
        return clear_str($this->deaacc);
    }

    public function scopeByNumber($query, $number)
    {
        return $query->where('deaacc', $number)->where('deaacd', '10');
    }

    public function getCustomerNumber()
    {
        return $this->deacun;
    }

    public function getDepositDate()
    {
        return '20' . $this->deaody . '-' . $this->deaodm . '-' . $this->deaodd;
    }

    public function getProductCode()
    {
        return $this->deapro;
    }

    public function getCurrency()
    {
        return $this->deaccy;
    }

    public function payments_plan()
    {
        return $this->hasMany(LoanPaymentPlan::class, 'dlpacc', 'deaacc')->orderBy('dlppnu');
    }
}
