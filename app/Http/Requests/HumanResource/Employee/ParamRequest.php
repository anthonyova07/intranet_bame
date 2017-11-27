<?php

namespace Bame\Http\Requests\HumanResource\Employee;

use Bame\Http\Requests\Request;

class ParamRequest extends Request
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
            'name' => 'required|unique:ibs.intrhemppa,name,' . $this->param,
            'level' => 'integer',
        ];
    }
}
