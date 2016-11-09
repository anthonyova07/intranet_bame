<?php

namespace Bame\Models\Customer\Product;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $connection = 'ibs';

    protected $table = 'acmst';

    protected $primaryKey = 'acmacc';

    public $incrementing = false;

    public $timestamps = false;

    public function getNumber()
    {
        return clear_str($this->acmacc);
    }

    public function getProductCode()
    {
        return $this->acmpro;
    }

    public function getCurrency()
    {
        return $this->acmccy;
    }
}
