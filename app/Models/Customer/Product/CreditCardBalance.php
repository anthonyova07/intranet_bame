<?php

namespace Bame\Models\Customer\Product;

use Illuminate\Database\Eloquent\Model;

class CreditCardBalance extends Model
{
    protected $connection = 'itc';

    protected $table = 'satmsal00';

    protected $primaryKey = 'tcact_msal';

    public $incrementing = false;

    public $timestamps = false;

    public function getNumber()
    {
        return clear_str($this->tcact_msal);
    }

    public function getMaskedNumber()
    {
        $tdc_1 = substr($this->tcact_msal, 0, 6);
        $tdc_2 = substr($this->tcact_msal, 12, 4);

        return substr($tdc_1, 0, 4) . '-' . substr($tdc_1, 4, 6) . '**-****-' . $tdc_2;
    }

    public function getPaymentsExpired()
    {
        return $this->canpv_msal;
    }

    public function getPaymentsExpiredDays()
    {
        return $this->canpv_msal * 30;
    }

    public function scopeByCreditcard($query)
    {
        return $query->where('tcact_msal', $this->tcact_msal);
    }
}
