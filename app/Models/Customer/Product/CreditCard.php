<?php

namespace Bame\Models\Customer\Product;

use Illuminate\Database\Eloquent\Model;

use Bame\Models\Customer\Customer;
use Bame\Models\Operation\Tdc\Itc\RequestDescription;
use Bame\Models\Operation\Tdc\Itc\TdcBinDescription;

class CreditCard extends Model
{
    protected $connection = 'itc';

    protected $table = 'satmtar00';

    protected $primaryKey = 'tcact_mtar';

    public $incrementing = false;

    public $timestamps = false;

    public function getNumber()
    {
        return clear_str($this->tcact_mtar);
    }

    public function getProductCode()
    {
        return $this->codpr_mtar;
    }

    public function getMaskedNumber()
    {
        $tdc_1 = substr($this->tcact_mtar, 0, 6);
        $tdc_2 = substr($this->tcact_mtar, 12, 4);

        return substr($tdc_1, 0, 4) . '-' . substr($tdc_1, 4, 6) . '**-****-' . $tdc_2;
    }

    public function transactions()
    {
        return $this->hasMany(CreditCardStatement::class, 'numta_dect', 'tcact_mtar');
    }

    public function balance($currency = 214)
    {
        return $this->hasOne(CreditCardBalance::class, 'tcact_msal', 'tcact_mtar')->where('moned_msal', $currency);
    }
}
