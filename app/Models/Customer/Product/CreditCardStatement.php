<?php

namespace Bame\Models\Customer\Product;

use Illuminate\Database\Eloquent\Model;

use Bame\Models\Customer\Customer;
use Bame\Models\Operation\Tdc\Itc\RequestDescription;
use Bame\Models\Operation\Tdc\Itc\TdcBinDescription;

class CreditCardStatement extends Model
{
    protected $connection = 'itc';

    protected $table = 'saumtra00';

    protected $primaryKey = 'numta_mtra';

    public $incrementing = false;

    public $timestamps = false;

    public function getNumber()
    {
        return clear_str($this->numta_mtra);
    }

    public function getMaskedNumber()
    {
        $tdc_1 = substr($this->numta_mtra, 0, 6);
        $tdc_2 = substr($this->numta_mtra, 12, 4);

        return substr($tdc_1, 0, 4) . '-' . substr($tdc_1, 4, 6) . '**-****-' . $tdc_2;
    }

    public function getDateTransaction()
    {
        return $this->fecha_mtra;
    }

    public function getTimeTransaction()
    {
        return $this->horas_mtra;
    }

    public function getFormatedDateTimeTransaction($toDate = false)
    {
        $year = substr($this->fecha_mtra, 0, 4);
        $month = substr($this->fecha_mtra, 4, 2);
        $day = substr($this->fecha_mtra, 6, 2);

        $time = str_pad($this->horas_mtra, 6, 0, STR_PAD_LEFT);

        $hour = substr($time, 0, 2);
        $minute = substr($time, 2, 2);
        $second = substr($time, 4, 2);

        if ($toDate) {
            return "{$year}-{$month}-{$day} {$hour}:{$minute}:{$second}.0";
        }

        return "{$day}/{$month}/{$year} {$hour}:{$minute}:{$second}";
    }

    public function getCountry()
    {
        return substr($this->cdanl_mtra, 38, 2);
    }

    public function getCity()
    {
        return cap_str(substr($this->cdanl_mtra, 25, 13));
    }

    public function getMerchantName() {
        return cap_str(substr($this->cdanl_mtra, 0, 25));
    }

    public function getAmount() {
        return $this->monta_mtra;
    }

    public function getCurrency()
    {
        switch ($this->moned_mtra) {
            case 214:
                return 'RD$';
                break;
            case 840:
                return 'US$';
                break;
            default:
                return 'Invalida';
                break;
        }
    }

    public function scopeByCreditcard($query, $creditcard)
    {
        return $query->where('numta_mtra', $creditcard);
    }
}
