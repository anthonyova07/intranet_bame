<?php

namespace Bame\Models\Customer\Claim;

use Illuminate\Database\Eloquent\Model;

use Bame\Models\Customer\Claim\Form\Form;

class Claim extends Model
{
    protected $connection = 'ibs';

    protected $table = 'intranet_claims';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public $timestamps = true;

    protected $dates = ['response_date', 'solved_date', 'received_at', 'approved_date', 'closed_date'];

    public function getProduct()
    {
        if (strlen($this->product_number) == 16) {
            $tdc_1 = substr($this->product_number, 0, 6);
            $tdc_2 = substr($this->product_number, 12, 4);

            return substr($tdc_1, 0, 4) . '-' . substr($tdc_1, 4, 6) . '**-****-' . $tdc_2;
        }

        return $this->product_number;
    }

    public function getFullName()
    {
        if ($this->is_company) {
            return $this->legal_name;
        }

        return $this->names . ' ' . $this->last_names;
    }

    public function getFormatIdentification()
    {
        if ($this->identification) {
            if (strlen($this->identification) == 11) {
                $id = $this->identification;
                return substr($id, 0, 3) . '-' . substr($id, 3, 7) . '-' . substr($id, 10, 1);
            } else if (strlen($this->identification) == 9) {
                return $this->identification;
            }
        } else {
            return strtoupper($this->passport);
        }
    }

    public function getOnePhoneNumber() {
        if ($this->cell_phone) {
            return $this->cell_phone;
        } else if ($this->residential_phone) {
            return $this->residential_phone;
        } else {
            return $this->office_phone;
        }
    }

    public function forms()
    {
        return $this->hasMany(Form::class, 'claim_id');
    }

    public function statuses()
    {
        return $this->hasMany(Status::class, 'claim_id');
    }

    public function createStatus($claim_status, $comment)
    {
        if (is_string($claim_status)) {
            $str = $claim_status;

            $claim_status = new \stdClass;
            $claim_status->code = '';
            $claim_status->description = $str;
        }

        $status = new Status;

        $status->id = uniqid(true);
        $status->claim_id = $this->id;
        $status->code = $claim_status->code;
        $status->description = $claim_status->description;
        $status->comment = $comment;

        $status->created_by = session()->get('user');
        $status->created_by_name = session()->get('user_info')->getFirstName() . ' ' . session()->get('user_info')->getLastName();

        $status->save();
    }
}
