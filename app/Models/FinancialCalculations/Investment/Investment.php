<?php

namespace Bame\Models\FinancialCalculations\Investment;

class Investment
{
    public $amount = 0;

    public $days = 0;

    public $interests = 0;

    public $total = 0;

    public $interests_earned = 0;

    public function __construct($amount, $days, $interests)
    {
        $this->amount = $amount;

        $this->days = $days;

        $this->interests = $interests;
    }

    public function calculate_interests()
    {
        $this->interests_earned = $this->amount * ((($this->interests / 100) / 360) * $this->days);
        $this->total = $this->amount + $this->interests_earned;
    }

    public static function min_max($str, $min = true)
    {
        $str = str_replace(',', '', $str);
        $str = str_replace(' ', '', $str);

        $parts = explode('-', $str);

        return [
            'min' => floatval($parts[0]) == 0 ? null : $parts[0],
            'max' => floatval($parts[1]) == 0 ? null : $parts[1],
        ];

        // if ($min) {
        //     return floatval($parts[0]) == 0 ? null : $parts[0];
        // } else {
        //     return floatval($parts[1]) == 0 ? null : $parts[1];
        // }
    }
}
