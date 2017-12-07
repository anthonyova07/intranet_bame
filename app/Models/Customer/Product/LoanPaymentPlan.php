<?php

namespace Bame\Models\Customer\Product;

use Illuminate\Database\Eloquent\Model;

use DateTime;

class LoanPaymentPlan extends Model
{
    protected $connection = 'ibs';

    protected $table = 'dlpmt';

    protected $primaryKey = 'dlpacc';

    public $incrementing = false;

    public $timestamps = false;

    public function getNumber()
    {
        return clear_str($this->dlpacc);
    }

    public function getCurrency()
    {
        return $this->dlpccy;
    }

    public function scopeQuotasExpired($query)
    {
        return $query->where('dlppfl', '')->orderBy('dlppnu');
    }

    public function daysExpired()
    {
        $year = '20' . $this->dlppdy;
        $month = $this->dlppdm;
        $day = $this->dlppdd;

        $payment_day = new DateTime($year . '-' . $month . '-' . $day);

        return $payment_day->diff(new DateTime)->days;
    }

    public function getDate()
    {
        return '20' . $this->dlppdy . '-' . $this->dlppdm . '-' . $this->dlppdd;
    }
}
