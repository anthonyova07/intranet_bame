<?php

namespace Bame\Http\Requests\Process\Request;

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
        if ($this->type == 'PRO') {
            return [
                'version' => 'required|max:45',
                'name' => 'required|max:255',
            ];
        } else {
            return [
                'code' => 'required|max:45',
                'description' => 'required|max:255',
            ];
        }
    }
}
