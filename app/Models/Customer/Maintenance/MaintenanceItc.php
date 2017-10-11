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
}
