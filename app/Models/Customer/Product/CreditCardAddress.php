<?php

namespace Bame\Models\Customer\Product;

use Illuminate\Database\Eloquent\Model;

class CreditCardAddress extends Model
{
    protected $connection = 'itc';

    protected $table = 'sasmdir00';//sasmdir00 direcciones de las tarjetas

    protected $primaryKey = 'tcact_mdir';

    public $incrementing = false;

    public $timestamps = false;

    public function getNumber()
    {
        return clear_str($this->tcact_mdir);
    }

    public function getMaskedNumber()
    {
        $tdc_1 = substr($this->tcact_mdir, 0, 6);
        $tdc_2 = substr($this->tcact_mdir, 12, 4);

        return substr($tdc_1, 0, 4) . '-' . substr($tdc_1, 4, 6) . '**-****-' . $tdc_2;
    }

    public function getMainPhoneArea() {
        return cap_str($this->areap_mdir);
    }

    public function getMainPhoneNumber() {
        return cap_str($this->nutep_mdir);
    }

    public function getMainPhoneExt() {
        return cap_str($this->extep_mdir);
    }

    public function getSecundaryPhoneArea() {
        return cap_str($this->areas_mdir);
    }

    public function getSecundaryPhoneNumber() {
        return cap_str($this->nutes_mdir);
    }

    public function getSecundaryPhoneExt() {
        return cap_str($this->extes_mdir);
    }

    public function scopeByCreditcard($query, $creditcard)
    {
        return $query->where('numta_mtra', $creditcard);
    }
}
