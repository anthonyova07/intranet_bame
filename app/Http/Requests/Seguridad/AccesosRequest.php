<?php

namespace Bame\Http\Requests\Seguridad;

use Bame\Http\Requests\Request;

class AccesosRequest extends Request
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
            'usuario' => 'required',
            'menu' => 'required|integer',
            'submenu' => 'required|integer',
        ];
    }
}
