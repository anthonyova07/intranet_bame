<?php

namespace Bame\Http\Requests\Risk\Event;

use Bame\Http\Requests\Request;

class ParamRiskEvent extends Request
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
            'code' => 'required|max:45',
            'description' => 'required|max:255',
        ];
    }
}