<?php

namespace Bame\Http\Requests\HumanResource\Calendar;

use Bame\Http\Requests\Request;

class GroupRequest extends Request
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
            'name' => 'required|max:150',
            // 'color' => 'required',
            'backcolor' => 'required',
            'bordcolor' => 'required',
            'textcolor' => 'required',
        ];
    }
}
