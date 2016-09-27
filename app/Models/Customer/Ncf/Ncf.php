<?php

namespace Bame\Models\Customer\Ncf;

use Illuminate\Database\Eloquent\Model;

use Bame\Models\Customer\Customer;

class Ncf extends Model
{
    protected $connection = 'ibs';

    protected $table = 'bacncfe';

    protected $primaryKey = 'encfact';

    public $incrementing = false;

    public $timestamps = false;

    public function getInvoice()
    {
        return clear_str($this->encfact);
    }

    public function getCustomerNumber()
    {
        return clear_str($this->enccli);
    }

    public function getName()
    {
        $customer = Customer::find($this->getCustomerNumber());

        if ($customer) {
            return cap_str($customer->cusna1);
        }

        return cap_str($this->encnom);
    }

    public function getProduct()
    {
        return clear_str($this->enccta);
    }

    public function getNcf()
    {
        return $this->encncf;
    }

    public function getMonthProcess()
    {
        return clear_str($this->encmesp);
    }

    public function getYearProcess()
    {
        return clear_str($this->encaniop);
    }

    public function getDateProcess()
    {
        $date_proccess = $this->getMonthProcess();
        $date_proccess .= '/';
        $date_proccess .= $this->getYearProcess();

        return $date_proccess;
    }

    public function getDayGenerated()
    {
        return clear_str($this->encdiag);
    }

    public function getMonthGenerated()
    {
        return clear_str($this->encmesg);
    }

    public function getYearGenerated()
    {
        return clear_str($this->encaniog);
    }

    public function getDateGenerated()
    {
        $date_generated = $this->getDayGenerated();
        $date_generated .= '/';
        $date_generated .= $this->getMonthGenerated();
        $date_generated .= '/';
        $date_generated .= $this->getYearGenerated();

        return $date_generated;
    }

    public function getAmount($with_format = true)
    {
        if ($with_format) {
            return number_format(clear_str($this->encmonto), 2);
        }

        return clear_str($this->encmonto);
    }

    public function setAmount($value)
    {
        $this->encmonto = $value;
    }

    public function getTaxAmount($with_format = true)
    {
        if ($with_format) {
            return number_format(clear_str($this->encreim), 2);
        }

        return clear_str($this->encreim);
    }

    public function getIdentificationType()
    {
        return clear_str($this->enctid);
    }

    public function getIdentification()
    {
        return clear_str($this->encidn);
    }
}
