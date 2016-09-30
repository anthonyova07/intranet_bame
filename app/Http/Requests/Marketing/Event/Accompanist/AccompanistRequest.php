<?php

namespace Bame\Http\Requests\Marketing\Event\Accompanist;

use Bame\Http\Requests\Request;

class AccompanistRequest extends Request
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
            'names' => 'required|max:45',
            'last_names' => 'required|max:45',
            'identification' => 'required|alpha_num|max:45',
        ];
    }
}
