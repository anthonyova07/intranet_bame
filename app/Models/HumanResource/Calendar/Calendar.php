<?php

namespace Bame\Models\HumanResource\Calendar;

use Illuminate\Database\Eloquent\Model;

use DateTime;

class Calendar extends Model
{
    // protected $connection = 'ibs';

    // protected $table = 'ninguna';

    // protected $primaryKey = 'id';

    // public $incrementing = false;

    // public $timestamps = true;

    // protected $dates = ['startdate', 'enddate'];

    public static function getPaymentsDays()
    {
        $datetime = new DateTime;

        $payment_dates_1 = new DateTime($datetime->format('Y-m') . '-13');
        $payment_dates_2 = new DateTime($datetime->format('Y-m') . '-28');

        $payments_days = collect();

        foreach (range(0, 12) as $value) {
            if ($value > 0) {
                $day_1 = $payment_dates_1->modify('+1 month')->format('l');
                $day_2 = $payment_dates_2->modify('+1 month')->format('l');
            } else {
                $day_1 = $payment_dates_1->format('l');
                $day_2 = $payment_dates_2->format('l');
            }

            if ($day_1 == 'Saturday') {
                $payments_days->push($payment_dates_1->modify('-1 day')->format('Y-m-d'));
                $payment_dates_1->modify('+1 day');
            } else if ($day_1 == 'Sunday') {
                $payments_days->push($payment_dates_1->modify('-2 day')->format('Y-m-d'));
                $payment_dates_1->modify('+2 day');
            } else {
                $payments_days->push($payment_dates_1->format('Y-m-d'));
            }

            if ($day_2 == 'Saturday') {
                $payments_days->push($payment_dates_2->modify('-1 day')->format('Y-m-d'));
                $payment_dates_2->modify('+1 day');
            } else if ($day_2 == 'Sunday') {
                $payments_days->push($payment_dates_2->modify('-2 day')->format('Y-m-d'));
                $payment_dates_2->modify('+2 day');
            } else {
                $payments_days->push($payment_dates_2->format('Y-m-d'));
            }
        }

        return $payments_days;
    }
}
