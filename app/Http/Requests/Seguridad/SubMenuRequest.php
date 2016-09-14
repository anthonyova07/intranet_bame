<?php

namespace Bame\Http\Requests\Seguridad;

use Bame\Http\Requests\Request;

class SubMenuRequest extends Request
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
            'menu' => 'required|integer',
            'coduni' => 'required|alpha_dash|max:50',
            'descripcion' => 'required|max:40',
            'caption' => 'required|max:100',
            'link' => 'required|max:30',
        ];
    }
}
