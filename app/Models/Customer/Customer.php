<?php

namespace Bame\Models\Customer;

use DB;
use Illuminate\Database\Eloquent\Model;
use Bame\Models\Customer\Product\Account;
use Bame\Models\Customer\Product\CreditCard;
use Bame\Models\Customer\Product\LoanMoneyMarket;

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
        return clear_str($this->cusln3);
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

    public function isCompany()
    {
        return $this->cuslgt == '1';
    }

    public function getLegalName()
    {
        return cap_str($this->cusna1);
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

    public function getCountry()
    {
        return cap_str($this->cusctr);
    }

    public function getPostalMail()
    {
        return cap_str($this->cuspob);
    }

    public function getZipCode()
    {
        return cap_str($this->cuszpc);
    }

    public function getResidentialOrBuilding()
    {
        return cap_str($this->cusna3);
    }

    public function getBuildingOrHouseNumber()
    {
        return cap_str($this->cusna4);
    }

    public function getProvince()
    {
        $province = DB::connection('ibs')->table('cnofc')->where('cnocfl', 'PV')->where('cnorcd', $this->cusste)->first();

        if (!$province) {
            return '';
        }

        return cap_str($province->cnodsc);
    }

    public function getCity()
    {
        $city = DB::connection('ibs')->table('cnofc')->where('cnocfl', 'PI')->where('cnorcd', $this->cusuc8)->first();

        if (!$city) {
            return '';
        }

        return cap_str($city->cnodsc);
    }

    public function getSector()
    {
        $city = DB::connection('ibs')->table('cnofc')->where('cnocfl', 'PE')->where('cnorcd', $this->cusuc7)->first();

        if (!$city) {
            return '';
        }

        return cap_str($city->cnodsc);
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

    public function getFaxPhone()
    {
        return '(' . cod_tel($this->cusfax) . ') ' . tel($this->cusfax);
    }

    public function getClearResidentialPhone()
    {
        return clear_str($this->cushpn);
    }

    public function getClearOfficePhone()
    {
        return clear_str($this->cusphn);
    }

    public function getClearCellPhone()
    {
        return clear_str($this->cusph1);
    }

    public function getClearFaxPhone()
    {
        return clear_str($this->cusfax);
    }

    public function getMail()
    {
        return clear_str($this->cusiad);
    }

    public function getMailType()
    {
        return clear_str($this->cusmlc);
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

    public function agent()
    {
        return $this->hasOne(Agent::class, 'cumcun', 'cuscun')->where('cumrtp', 5);
    }

    public function loans()
    {
        return $this->hasMany(LoanMoneyMarket::class, 'deacun')->where('deaacd', '10')->where('deasts', '<>', 'C');
    }

    public function money_markets()
    {
        return $this->hasMany(LoanMoneyMarket::class, 'deacun')->where('deaacd', '11');
    }

    public function accounts_sav()
    {
        return $this->hasMany(Account::class, 'acmcun')->where('acmacd', '04')->where('acmast', 'A');
    }

    public function accounts_dda()
    {
        return $this->hasMany(Account::class, 'acmcun')->where('acmacd', '<>', '04')->where('acmast', 'A');
    }

    public function creditcards()
    {
        return $this->hasMany(CreditCard::class, 'codcl_mtar');
    }

    public function actives_creditcards()
    {
        return $this->hasMany(CreditCard::class, 'codcl_mtar')->where(function ($query) {
            $query->where('stsrd_mtar', 1)->orWhere('stsrd_mtar', 6);
        });
    }

    public function scopeSearchByIdentification($query, $identification)
    {
        return $query->where('cusidn', $identification)->orWhere('cusln3', $identification);
    }
}
