<?php

namespace Bame\Models\Customer\Maintenance;

use DB;
use Illuminate\Database\Eloquent\Model;
use Bame\Models\Customer\Product\Account;
use Bame\Models\Customer\Product\CreditCard;
use Bame\Models\Customer\Product\LoanMoneyMarket;

class MaintenanceItc extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intmaiitc';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = false;

    protected $dateFormat = 'Y-m-d H:i:s';

    public function getMainPhone()
    {
        return '(' . $this->itcmphoare . ') ' . $this->itcmphonum . '-' . $this->itcmphoext;
    }

    public function getSecundaryPhone()
    {
        return '(' . $this->itcsphoare . ') ' . $this->itcsphonum . '-' . $this->itcsphoext;
    }

    public function getMainCel()
    {
        return '(' . $this->itcmcelare . ') ' . $this->itcmcelnum;
    }

    public function getSecundaryCel()
    {
        return '(' . $this->itcscelare . ') ' . $this->itcscelnum;
    }

    public function getFax()
    {
        return '(' . $this->itcfaxarea . ') ' . $this->itcfaxnumb;
    }
}
