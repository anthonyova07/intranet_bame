<?php

namespace Bame\Models\CashTransaction;

use Illuminate\Database\Eloquent\Model;

class CashTransaction extends Model
{
    protected $connection = 'ibs';

    protected $primaryKey = 'ticrfn';

    public $incrementing = false;

    public $timestamps = false;

    public function getDocument()
    {
        return clear_str($this->ticidn);
    }

    public function getDescription()
    {
        return 'CARGO POR TRANSFERENCIA';
    }

    public function getAmount()
    {
        return floatval($this->ticdch) * floatval($this->ticexr);
    }

    public function getCurrency()
    {
        return 'RD$';
        // return strtoupper(clear_str($this->ticccy));
    }

    public function getQuantity()
    {
        return 1;
    }

    public function getType()
    {
        return 'D';
    }

    public function getCustomerCode()
    {
        return clear_str($this->ticocs);
    }

    public function getDay()
    {
        return clear_str($this->ticrdd);
    }

    public function getMonth()
    {
        return clear_str($this->ticrdm);
    }

    public function getYear()
    {
        return clear_str($this->ticrdy);
    }

    public function getDate()
    {
        return $this->getDay() . '/' . $this->getMonth() . '/' . $this->getYear();
    }
}
