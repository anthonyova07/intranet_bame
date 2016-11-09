<?php

namespace Bame\Models\Customer\Claim;

use Illuminate\Database\Eloquent\Model;

class Claim extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intranet_claims';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;

    protected $dates = ['response_date', 'solved_date', 'received_at'];
}
