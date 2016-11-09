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

    public function getProductCode()
    {
        return $this->deapro;
    }

    public function getCurrency()
    {
        return $this->deaccy;
    }
}
