<?php

namespace Bame\Http\Requests\Risk\Event;

use Bame\Http\Requests\Request;

class RiskEventRequest extends Request
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
            'business_line' => 'required',
            'event_type' => 'required',
            'currency_type' => 'required',
            'branch_office' => 'required',
            'area_department' => 'required',
            'distribution_channel' => 'required',
            'process' => 'required',
            'subprocess' => 'required',
            'description' => 'required|max:1000',
            'consequence' => 'required|max:1000',
            'associated_control' => 'required|max:1000',
        ];
    }
}
