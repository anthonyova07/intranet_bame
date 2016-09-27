<?php

namespace Bame\Models\Customer;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $connection = 'ibs';

    protected $table = 'cumst';

    protected $primaryKey = 'cuscun';

    public $incrementing = false;

    public $timestamps = false;

    public function setCustomerFromCensus($customer)
    {
        $this->cusln3 = $customer->cedidn;
        $this->cusfna = $customer->cedno1;
        $this->cusfn2 = $customer->cedno2;
        $this->cusln1 = $customer->cedap1;
        $this->cusln2 = $customer->cedap2;
    }

    public function getCode()
    {
        return clear_str($this->cuscun);
    }

    public function getPassport()
    {
        return clear_str($this->cusidn);
    }

    public function getDocument()
    {
        return cap_str($this->cusln3);
    }

    public function getFirstName()
    {
        return cap_str($this->cusfna);
    }

    public function getSecondName()
    {
        return cap_str($this->cusfn2);
    }

    public function getFirstLastName()
    {
        return cap_str($this->cusln1);
    }

    public function getSecondLastName()
    {
        return cap_str($this->cusln2);
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

    public function getGender()
    {
        return clear_str($this->cussex);
    }

    public function getNation()
    {
        return clear_str($this->cusccs);
    }

    public function getMaritalStatus()
    {
        return clear_str($this->cusmst);
    }

    public function getBirthdate()
    {
        $birth_date = clear_str($this->cusbdd);
        $birth_date .= '/';
        $birth_date .= clear_str($this->cusbdm);
        $birth_date .= '/';
        $birth_date .= clear_str($this->cusbdy);

        return $birth_date;
    }

    public function getStreet()
    {
        return cap_str($this->cusna2);
    }

    public function getHouse()
    {
        return cap_str($this->cusna3);
    }

    public function getBuilding()
    {
        return cap_str($this->cusna4);
    }

    public function getResidentialPhone()
    {
        return '(' . cod_tel($this->cushpn) . ') ' . tel($this->cushpn);
    }

    public function getOfficePhone()
    {
        return '(' . cod_tel($this->cusphn) . ') ' . tel($this->cusphn);
    }

    public function getCellPhone()
    {
        return '(' . cod_tel($this->cusph1) . ') ' . tel($this->cusph1);
    }

    public static function getPhoto($identification)
    {
        $identification = clear_str($identification);

        $c1 = substr($identification, 0, 3);
        $c2 = substr($identification, 3, 2);
        $c3 = substr($identification, 5, 2);

        $photo = env('ENCARTES_CARPETA_FOTO') . $c1 . '\\' . $c2 . '\\' . $c3 . '\\' . format_identification($identification) . '.jpg';

        if (!file_exists($photo)) {
            $photo = base_path('\\public\\images\\noFoto.jpg');
        }
        return $photo;
    }
}
