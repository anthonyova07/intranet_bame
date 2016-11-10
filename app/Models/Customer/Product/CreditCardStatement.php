<?php

namespace Bame\Models\Customer\Product;

use Illuminate\Database\Eloquent\Model;

use Bame\Models\Customer\Customer;
use Bame\Models\Operation\Tdc\Itc\RequestDescription;
use Bame\Models\Operation\Tdc\Itc\TdcBinDescription;

class CreditCardStatement extends Model
{
    protected $connection = 'itc';

    protected $table = 'satdect00';

    protected $primaryKey = 'numta_dect';

    public $incrementing = false;

    public $timestamps = false;

    public function getNumber()
    {
        return clear_str($this->numta_dect);
    }

    public function getMaskedNumber()
    {
        $tdc_1 = substr($this->numta_dect, 0, 6);
        $tdc_2 = substr($this->numta_dect, 12, 4);

        return substr($tdc_1, 0, 4) . '-' . substr($tdc_1, 4, 6) . '**-****-' . $tdc_2;
    }

    public function getDateTransaction()
    {
        return $this->fectr_dect;
    }

    public function getFormatedDateTransaction()
    {
        if (strlen($this->fectr_dect) == 7) {
            $day = substr($this->fectr_dect, 0, 1);
            $month = substr($this->fectr_dect, 1, 2);
            $year = substr($this->fectr_dect, 3, 4);
        } else {
            $day = substr($this->fectr_dect, 0, 2);
            $month = substr($this->fectr_dect, 2, 2);
            $year = substr($this->fectr_dect, 4, 4);
        }

        return str_pad($day, 2, 0, STR_PAD_LEFT) . '/' . $month . '/' . $year;
    }

    public function getConcept() {
        return cap_str($this->conce_dect);
    }

    public function isDebit() {
        return boolval($this->debit_dect);
    }

    public function getAmount() {
        if ($this->isDebit()) {
            return $this->debit_dect;
        }

        return $this->credt_dect;
    }

    public function getCurrency()
    {
        switch ($this->moned_dect) {
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
}
