<?php

namespace Bame\Models\FinancialCalculations\Loan;

class Loan
{
    public $amount = 0;

    public $months = 0;

    public $interests = 0;

    public $extraordinary = 0;

    public $month_extraordinary = 12;

    public $start_date = null;

    public $total_interests = 0;

    public function __construct($amount, $months, $interests, $extraordinary = 0, $month_extraordinary = 12, $start_date = null)
    {
        $this->amount = $amount;

        $this->months = $months;

        $this->interests = $interests;

        $this->extraordinary = $extraordinary;

        $this->month_extraordinary = $month_extraordinary ? $month_extraordinary : 12;

        $this->start_date = $start_date ? $start_date : datetime()->format('Y-m-d');
    }

    public function quota()
    {
        $interests = $this->getInterests();

        $power = pow((1 + $interests), ($this->months));

        return ($this->amount * $interests * $power) / ($power - 1);
    }

    public function amortizations()
    {
        $amortizations = collect();

        $capital_pending = $this->amount;
        $quota = $this->quota();
        $interests = $this->getInterests();
        $date = datetime($this->start_date);

        for ($i = 1; $i <= $this->months; $i++) {
            $amortization = new \stdClass;

            $amortization->month = $i;
            $amortization->interests = $capital_pending * $interests;
            $amortization->date = $date->format('d/m/Y');

            if ($date->format('m') == $this->month_extraordinary) {
                $amortization->extraordinary = $this->extraordinary;
                $amortization->capital = $quota - ($capital_pending * $interests);
                $amortization->quota = $amortization->interests + $amortization->capital + $this->extraordinary;
                $capital_pending = $capital_pending - ($quota - ($capital_pending * $interests)) - $this->extraordinary;
            } else {
                $amortization->extraordinary = 0;
                $amortization->capital = $quota - ($capital_pending * $interests);
                $amortization->quota = $amortization->interests + $amortization->capital;
                $capital_pending = $capital_pending - ($quota - ($capital_pending * $interests));
            }

            $amortization->capital_pending = $capital_pending < 0 ? 0 : $capital_pending;

            $amortizations->push($amortization);

            $date->modify('+1 month');

            if ($amortization->capital_pending == 0) {
                break;
            }
        }

        return $amortizations;
    }

    public function getInterests()
    {
        return ($this->interests / 100) / 12;
    }

    public function getExtraordinary()
    {
        return ($this->months / 12) * $this->extraordinary;
    }

}
