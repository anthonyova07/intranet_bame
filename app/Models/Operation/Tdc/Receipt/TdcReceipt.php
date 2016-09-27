<?php

namespace Bame\Models\Operation\Tdc\Receipt;

use Illuminate\Database\Eloquent\Model;

use Bame\Models\Customer\Customer;
use Bame\Models\Operation\Tdc\Itc\RequestDescription;
use Bame\Models\Operation\Tdc\Itc\TdcBinDescription;

class TdcReceipt extends Model
{
    protected $connection = 'itc';

    protected $table = 'sadentr00';

    protected $primaryKey = 'numta_entr';

    public $incrementing = false;

    public $timestamps = false;

    public function getCreditCard()
    {
        return clear_str($this->numta_entr);
    }

    public function getMaskedCreditCard()
    {
        $tdc_1 = substr($this->numta_entr, 0, 4);
        $tdc_2 = substr($this->numta_entr, 12, 4);

        return $tdc_1 . '-****-****-' . $tdc_2;
    }

    public function getDocument()
    {
        return clear_str($this->ident_entr);
    }

    public function getFormattedDocument()
    {
        return format_identification($this->ident_entr);
    }

    public function getFirstName()
    {
        return cap_str($this->nomb1_entr);
    }

    public function getSecondName()
    {
        return cap_str($this->nomb2_entr);
    }

    public function getFirstLastName()
    {
        return cap_str($this->apel1_entr);
    }

    public function getSecondLastName()
    {
        return cap_str($this->apel2_entr);
    }

    public function getNames()
    {
        return $this->getFirstName() . ' ' . $this->getSecondName();
    }

    public function getLastNames()
    {
        return $this->getFirstLastName() . ' ' . $this->getSecondLastName();
    }

    public function getName()
    {
        return $this->getFirstName() . ' ' . $this->getFirstLastName();
    }

    public function getDopLimit()
    {
        return number_format($this->limrd_entr, 2);
    }

    public function getUsdLimit()
    {
        return number_format($this->limus_entr, 2);
    }

    public function getCycle()
    {
        return (int) clear_str($this->ciclo_entr);
    }

    public function getBuilding()
    {
        return cap_str($this->edifi_entr);
    }

    public function getNeighborhood()
    {
        return cap_str($this->barri_entr);
    }

    public function getStreet()
    {
        return cap_str($this->calle_entr);
    }

    public function getCity()
    {
        return cap_str($this->ciuda_entr);
    }

    public function getAddress()
    {
        return $this->getBuilding() . ' ' . $this->getNeighborhood() . ' ' . $this->getStreet() . ' ' . $this->getCity();
    }

    public function getResidentialPhone()
    {
        if ($this->codt1_entr == '0') {
            $customer = Customer::where('cusln3', $this->ident_entr)
                ->orWhere('cusidn', $this->ident_entr)
                ->first();

            if ($customer) {
                return $customer->getResidentialPhone();
            }
        }

        return '(' . clear_str($this->codt1_entr) . ') ' . clear_str($this->telre_entr);
    }

    public function getOfficePhone()
    {
        if ($this->codt2_entr == '0') {
            $customer = Customer::where('cusln3', $this->ident_entr)
                ->orWhere('cusidn', $this->ident_entr)
                ->first();

            if ($customer) {
                return $customer->getOfficePhone();
            }
        }

        return '(' . clear_str($this->codt2_entr) . ') ' . clear_str($this->telof_entr);
    }

    public function getOfficePhoneExtension()
    {
        return clear_str($this->extel_entr);
    }

    public function getCellPhone()
    {
        if ($this->codt3_entr == '0') {
            $customer = Customer::where('cusln3', $this->ident_entr)
                ->orWhere('cusidn', $this->ident_entr)
                ->first();

            if ($customer) {
                return $customer->getCellPhone();
            }
        }

        return '(' . clear_str($this->codt3_entr) . ') ' . clear_str($this->celul_entr);
    }

    public function getComment()
    {
        return cap_str($this->comen_entr);
    }

    public function getDate()
    {
        return clear_str($this->fecen_entr);
    }

    public function getTime()
    {
        return clear_str($this->horen_entr);
    }

    public function getPhoto()
    {
        return Customer::getPhoto($this->ident_entr);
    }

    public function request_type($request_types)
    {
        return cap_str($request_types
            ->where('codig_desc', $this->tipso_entr)
            ->first()->nombr_desc);
    }

    public function description_tdc_bin($descriptions_tdc_bin)
    {
        return cap_str($descriptions_tdc_bin
            ->where('numta_bin', substr($this->numta_entr, 0, 6))
            ->first()->descr_bin);
    }

    public static function generatePdf($html, $archivo)
    {
        generate_pdf($html, $archivo);
    }
}
