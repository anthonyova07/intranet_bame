<?php

namespace Bame\Http\Requests\Customer\Requests\Tdc;

use Bame\Http\Requests\Request;

class RequestTdcRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'plastic_name' => 'required|max:27',
            'marital_status' => 'required|in:' . get_marital()->keys()->implode(','),
            'pstreet' => 'required|max:150',
            'pnum' => 'required|max:10',
            'pbuilding' => 'required|max:100',
            'pbuilding' => 'required|max:100',
            'papartment' => 'required|max:100',
            'psector' => 'required|max:100',
            'pcountry' => 'required|max:100',
            'pmail' => 'required|email|max:100',
            'pnear' => 'required|max:100',
            'pschedule' => 'required|max:100',
            'pphone_res' => 'required|max:100',
            'pphone_cel' => 'required|max:100',
            'business_name' => 'required|max:100',
            'position' => 'required|max:100',
            'working_time' => 'required|max:50',
            'monthly_income' => 'required|numeric|max:99999999.99',
            'others_income' => 'required|numeric|max:99999999.99',
            'others_income' => 'required|numeric|max:99999999.99',
            'lstreet' => 'required|max:150',
            'lnum' => 'required|max:10',
            'lbuilding' => 'required|max:100',
            'lbuilding' => 'required|max:100',
            'lapartment' => 'required|max:100',
            'lsector' => 'required|max:100',
            'lcountry' => 'required|max:100',
            'lmail' => 'required|email|max:100',
            'lnear' => 'required|max:100',
            'lschedule' => 'required|max:100',
            'lphone_off' => 'required|max:100',
            'lphone_ext' => 'required|max:100',
            'lphone_fax' => 'required|max:100',
            'ref_1_name' => 'required|max:100',
            'ref_1_phone_res' => 'required|max:100',
            'ref_1_phone_cel' => 'required|max:100',
            'ref_2_name' => 'required|max:100',
            'ref_2_phone_res' => 'required|max:100',
            'ref_2_phone_cel' => 'required|max:100',
        ];
    }
}
