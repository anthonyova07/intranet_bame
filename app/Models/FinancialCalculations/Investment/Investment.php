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
}
