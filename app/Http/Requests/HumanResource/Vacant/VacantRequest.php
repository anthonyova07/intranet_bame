<?php

namespace Bame\Http\Requests\HumanResource\Vacant;

use Bame\Http\Requests\Request;

class VacantRequest extends Request
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
            'detail' => 'required|max:10000',
        ];
    }
}
