<?php

namespace Bame\Models\Customer\Claim\Form;

use Illuminate\Database\Eloquent\Model;

use Bame\Models\Customer\Claim\Claim;

class Transaction extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intrclaftr';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = false;

    protected $dates = ['transaction_date'];

    public function consumption()
    {
        return $this->belongsTo(Consumption::class, 'form_id')->where('form_type', 'CON');
    }

    public function getCurrency()
    {
        switch ($this->currency) {
            case '214':
                return 'RD$';
                break;
            case '840':
                return 'US$';
                break;
            default:
                return '';
                break;
        }
    }
}
