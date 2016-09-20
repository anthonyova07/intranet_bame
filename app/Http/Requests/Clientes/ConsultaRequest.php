<?php

namespace Bame\Http\Requests\Clientes;

use Bame\Http\Requests\Request;

class ConsultaRequest extends Request
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
            'identificacion' => 'required|alpha_dash'
        ];
    }
}