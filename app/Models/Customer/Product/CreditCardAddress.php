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

    public function getSecundaryPhoneArea()
    {
        return cap_str($this->areas_mdir);
    }

    public function getSecundaryPhoneNumber()
    {
        return cap_str($this->nutes_mdir);
    }

    public function getSecundaryPhoneExt()
    {
        return cap_str($this->extes_mdir);
    }

    public function getMainCellArea() {
        return cap_str($this->arecp_mdir);
    }

    public function getMainCellNumber() {
        return cap_str($this->nutcp_mdir);
    }

    public function getSecundaryCellArea() {
        return cap_str($this->arecs_mdir);
    }

    public function getSecundaryCellNumber() {
        return cap_str($this->nutcs_mdir);
    }

    public function getFaxArea() {
        return cap_str($this->areaf_mdir);
    }

    public function getFaxNumber() {
        return cap_str($this->numfx_mdir);
    }

    public function getBuildingName()
    {
        return cap_str($this->edifc_mdir);
    }

    public function getBlock()
    {
        return cap_str($this->manzc_mdir);
    }

    public function getHouseNumber()
    {
        return cap_str($this->numca_mdir);
    }

    public function getKm()
    {
        return cap_str($this->kilom_mdir);
    }

    public function getPostalZone()
    {
        return cap_str($this->zonap_mdir);
    }

    public function getPostalMail()
    {
        return cap_str($this->apost_mdir);
    }

    public function getInStreet1()
    {
        return cap_str($this->call1_mdir);
    }

    public function getInStreet2()
    {
        return cap_str($this->call2_mdir);
    }

    public function getSpecialInstruction()
    {
        return cap_str($this->instd_mdir);
    }

    public function getWaySendingStatement()
    {
        return cap_str($this->foree_mdir);
    }

    public function getMail()
    {
        return cap_str($this->email_mdir);
    }

    public function getRegion()
    {
        return cap_str($this->regio_mdir);
    }

    public function getProvince()
    {
        return cap_str($this->provi_mdir);
    }

    public function getCity()
    {
        return cap_str($this->ciucl_mdir);
    }

    public function getMunicipality()
    {
        return cap_str($this->munic_mdir);
    }

    public function getSector()
    {
        return cap_str($this->sectr_mdir);
    }

    public function getNeighborhood()
    {
        return cap_str($this->barri_mdir);
    }

    public function getStreet()
    {
        return cap_str($this->barri_mdir);
    }

    public function scopeByCreditcard($query, $creditcard)
    {
        return $query->where('numta_mtra', $creditcard);
    }
}
