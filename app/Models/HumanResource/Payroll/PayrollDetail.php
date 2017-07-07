<?php

namespace Bame\Models\HumanResource\Payroll;

use Illuminate\Database\Eloquent\Model;

class PayrollDetail extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intrhpayrd';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = false;

    protected $dates = ['transdate'];

    public function payroll()
    {
        return $this->belongsTo(Payroll::class, 'payroll_id', 'id');
    }
}
