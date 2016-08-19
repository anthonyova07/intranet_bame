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
            'menu' => 'required',
            'descripcion' => 'required',
            'caption' => 'required',
            'link' => 'required',
        ];
    }
}
