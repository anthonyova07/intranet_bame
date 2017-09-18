<?php

namespace Bame\Http\Requests\Security;

use Bame\Http\Requests\Request;

class AccessRequest extends Request
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
            'user' => 'required|exists:ibs.intrhemplo,useremp',
            'menu' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'user.exists' => 'Nombre de Usuario no existe.',
        ];
    }
}
