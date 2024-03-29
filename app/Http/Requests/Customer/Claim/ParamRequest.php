<?php

namespace Bame\Http\Requests\Customer\Claim;

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
        if ($this->type == 'TDC') {
            return [
                'es_name' => 'required|max:500',
                'es_detail' => 'required|max:500',
                'es_detail_2' => 'max:500',
                'en_name' => 'required|max:500',
                'en_detail' => 'required|max:500',
                'en_detail_2' => 'max:500',
            ];
        } else {
            return [
                'code' => 'required|max:255',
                'description' => 'required|max:255',
            ];
        }
    }
}
