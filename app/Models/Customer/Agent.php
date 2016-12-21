<?php

namespace Bame\Models\Customer;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $connection = 'ibs';

    protected $table = 'cumad';

    protected $primaryKey = '';

    public $incrementing = false;

    public $timestamps = false;

    public function getLegalName()
    {
        return cap_str($this->cumma1);
    }

    public function getIdentification()
    {
        return clear_str($this->cumbni);
    }

    public function getPhoneNumber()
    {
        return '(' . cod_tel($this->cumhpn) . ') ' . tel($this->cumhpn);
    }
}
