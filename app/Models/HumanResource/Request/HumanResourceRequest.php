<?php

namespace Bame\Models\HumanResource\Request;

use DateTime;
use Bame\Models\HumanResource\Calendar\Date;
use Illuminate\Database\Eloquent\Model;

class HumanResourceRequest extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intreqrh';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;

    public function scopeActiveOnly($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeLastestFirst($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function detail()
    {
        return $this->hasOne(Detail::class, 'req_id');
    }

    public static function isValidVacDateFrom($date)
    {
        $holidays_count = Date::holidaysDays()
            ->where('startdate', $date)
            ->count();

        $week_day = (new DateTime($date))->format('l');

        if ($week_day == 'Saturday' || $week_day == 'Sunday' || $holidays_count >= 1) {
            return false;
        }

        return true;
    }

    public static function getVacDateTo($start_date, $total_days)
    {
        $date_from = new DateTime($start_date);
        $date_to = (new DateTime($date_from->format('Y-m-d')))->modify('+' . $total_days . ' day');

        $holidays_days = Date::holidaysDays()
            ->where('startdate', '>', $date_from->format('Y-m-d'))
            ->where('enddate', '<', $date_to->format('Y-m-d'))
            ->get();

        foreach ($holidays_days as $holidays_day) {
            $holiday = (new DateTime($holidays_day->startdate))->format('l');

            if ($holiday != 'Saturday' && $holiday != 'Sunday') {
                $date_to->modify('+1 day');
            }
        }

        $current_date = new DateTime($date_from->format('Y-m-d'));

        while ($current_date <= $date_to) {
            $week_day = $current_date->format('l');

            if ($week_day == 'Saturday' || $week_day == 'Sunday') {
                $date_to->modify('+1 day');
            }

            $current_date->modify('+1 day');
        }

        return $date_to->format('Y-m-d');
    }

    public static function isBetweenXDays($date, $days = 5)
    {
        $current = new DateTime;
        $current->modify('+1 day');

        $post_day = new DateTime($date);
        $counter = 0;

        while ($current <= $post_day) {
            $week_day = $current->format('l');
            $current->modify('+1 day');

            if ($week_day != 'Saturday' && $week_day != 'Sunday') {
                $counter++;
            }
        }

        return $counter >= $days;
    }
}
