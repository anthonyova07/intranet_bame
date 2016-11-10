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

    public function getProduct()
    {
        if (strlen($this->product_number) == 16) {
            $tdc_1 = substr($this->product_number, 0, 6);
            $tdc_2 = substr($this->product_number, 12, 4);

            return substr($tdc_1, 0, 4) . '-' . substr($tdc_1, 4, 6) . '**-****-' . $tdc_2;
        }

        return $this->product_number;
    }
}
