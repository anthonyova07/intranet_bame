<?php

namespace Bame\Models\IB\Customer;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $connection = 'sqlsrv_ibcustomers';

    protected $table = 'Customers';

    protected $primaryKey = 'customerID';

    public $incrementing = false;

    public $timestamps = false;
}
