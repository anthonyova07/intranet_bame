<?php

namespace Bame\Http\Requests\HumanResource\Calendar;

use Bame\Http\Requests\Request;

class DateRequest extends Request
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
            'group_id' => 'required',
            'title' => 'required|max:200',
            'startdate' => 'required|date_format:"Y-m-d"',
            'enddate' => 'required|date_format:"Y-m-d"',
        ];
    }
}
