<?php

namespace Bame\Models\Customer\Claim\Form;

use Illuminate\Database\Eloquent\Model;

use Bame\Models\Customer\Claim\Claim;

class Consumption extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intranet_claim_form_consumption';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;

    protected $dates = ['response_date'];

    public function getProduct()
    {
        if (strlen($this->product_number) == 16) {
            $tdc_1 = substr($this->product_number, 0, 6);
            $tdc_2 = substr($this->product_number, 12, 4);

            return substr($tdc_1, 0, 4) . '-' . substr($tdc_1, 4, 6) . '**-****-' . $tdc_2;
        }

        return $this->product_number;
    }

    public function claim()
    {
        return $this->belongsTo(Claim::class, 'claim_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'form_id')->where('form_type', 'CON');
    }
}
