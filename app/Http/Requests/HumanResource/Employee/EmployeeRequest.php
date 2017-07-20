<?php

namespace Bame\Http\Requests\HumanResource\Employee;

use Bame\Http\Requests\Request;

class EmployeeRequest extends Request
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
            'recordcard' => 'required|integer|unique:ibs.intrhemplo,recordcard,' . $this->employee,
            'name' => 'required|string|max:150',
            'identification' => 'required|max:45|unique:ibs.intrhemplo,identifica,' . $this->employee,
            'mail' => 'required|email|max:150|unique:ibs.intrhemplo,mail,' . $this->employee,
            'birthdate' => 'required|date_format:"Y-m-d"',
            'servicedat' => 'required|date_format:"Y-m-d"',
            'gender' => 'required|in:f,m',
            'position' => 'required',
            'department' => 'required',
            // 'supervisor' => 'required',
        ];
    }
}
