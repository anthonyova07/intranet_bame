<?php

namespace Bame\Http\Requests\Customer\Ncf\Divisa\Detail;

use Bame\Http\Requests\Request;

class EditRequest extends Request
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
            'description' => 'required|max:50',
        ];
    }
}
