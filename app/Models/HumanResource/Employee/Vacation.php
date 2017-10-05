<?php

namespace Bame\Models\HumanResource\Employee;

use Illuminate\Database\Eloquent\Model;

class Vacation extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intempvacs';

    // protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = false;

    public function scopeByCode($query, $code)
    {
        return $query->where('recordcard', $code);
    }

    public function scopeExist($query, $year)
    {
        return $query->where('year', $year);
    }

    public static function reduceVacationDaysForYear($year, $day_took)
    {
        $query = self::where('recordcard', session('employee')->recordcard)->where('year', $year);

        $vacation = $query->first();

        if ($vacation) {
            $vacation->remaining -= $day_took;

            if ($vacation->remaining == 0) {
                $query->delete();
            } else {
                $query->update([
                    'remaining' => $vacation->remaining,
                ]);
            }
        }
    }
}
