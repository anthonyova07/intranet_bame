<?php

namespace Bame\Models\Customer\Product;

use Bame\Models\Customer\Customer;
use Illuminate\Database\Eloquent\Model;
use Bame\Models\Operation\Tdc\Description;
use Bame\Models\Customer\Product\CreditCardAddress;
use Bame\Models\Operation\Tdc\Itc\TdcBinDescription;
use Bame\Models\Operation\Tdc\Itc\RequestDescription;

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

    public function product()
    {
        $this->codpr_mtar =  str_pad($this->codpr_mtar, 4, '0', STR_PAD_LEFT);
        return $this->hasOne(Description::class, 'codig_desc', 'codpr_mtar')->where('prefi_desc', 'SAT_PROD');
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

    public function getIdentification()
    {
        return $this->indcl_mtar;
    }

    public function getPlasticName()
    {
        return cap_str($this->nompl_mtar);
    }

    public function address_one()
    {
        return $this->hasOne(CreditCardAddress::class, 'tcact_mdir', 'tcact_mtar')->where('iddir_mdir', '1');
    }

    public function address_two()
    {
        return $this->hasOne(CreditCardAddress::class, 'tcact_mdir', 'tcact_mtar')->where('iddir_mdir', '2');
    }
}
