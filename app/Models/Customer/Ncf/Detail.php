<?php

namespace Bame\Models\Customer\Ncf;

use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    protected $connection = 'ibs';

    protected $table = 'bacncfd';

    protected $primaryKey = 'detsec';

    public $incrementing = false;

    public $timestamps = false;

    public function getQuantity()
    {
        return clear_str($this->detcant);
    }

    public function getInvoice()
    {
        return clear_str($this->detfac);
    }

    public function getProduct()
    {
        return clear_str($this->detcta);
    }

    public function getSequence()
    {
        return clear_str($this->detsec);
    }

    public function getDescription()
    {
        return cap_str($this->detdesc);
    }

    public function getCurrency()
    {
        return $this->detccy;
    }

    public function getRate()
    {
        return (float) clear_str($this->dettas);
    }

    public function getAmount()
    {
        return (float) clear_str($this->detmto);
    }

    public function getDayGenerated()
    {
        return clear_str($this->detdia);
    }

    public function getMonthGenerated()
    {
        return clear_str($this->detmes);
    }

    public function getYearGenerated()
    {
        return clear_str($this->detanio);
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

    public function getStatus()
    {
        return $this->deasts;
    }

    public function getTaxAmount($with_format = true)
    {
        if ($this->detitb && $with_format) {
            return number_format(clear_str($this->detitb), 2);
        }

        return clear_str($this->detitb);
    }
}
