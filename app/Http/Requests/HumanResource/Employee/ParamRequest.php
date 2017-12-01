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
        $v = [
            'name' => 'required|unique:ibs.intrhemppa,name,' . $this->param,
        ];

        if ($this->type == 'LEVPOS') {
            $v = array_merge($v, ['level' => 'required|integer']);
        }

        if ($this->type == 'POS') {
            $v = array_merge($v, ['level' => 'required']);
        }

        return $v;
    }
}
