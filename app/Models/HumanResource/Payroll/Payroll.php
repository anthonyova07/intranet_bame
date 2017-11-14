<?php

namespace Bame\Models\HumanResource\Payroll;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intrhpayro';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;

    protected $dates = ['payroldate'];

    public function details()
    {
        return $this->hasMany(PayrollDetail::class, 'payroll_id', 'id');
    }

    public function scopeByActualUser($query)
    {
        return $query->where('recordcard', session('employee')->recordcard)->orderBy('payroldate', 'desc');
    }

    public function scopeDate($query, $date)
    {
        return $this->byActualUser()->where('payroldate', $date);
    }

    public static function exists($date)
    {
        return (bool) self::where('payroldate', $date)->count();
    }
}
