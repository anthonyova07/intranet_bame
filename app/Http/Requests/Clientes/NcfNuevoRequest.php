<?php

namespace Bame\Http\Requests\Clientes;

use Bame\Http\Requests\Request;

class NcfNuevoRequest extends Request
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
            'dia_desde' => 'required|integer|between:1,31',
            'dia_hasta' => 'required|integer|between:' . $this->dia_desde . ',31',
            'mes' => 'required|integer|between:1,12',
            'anio' => 'required|integer|between:2015,' . (new \DateTime)->format('Y'),
            'codigo_cliente' => 'required|integer',
        ];
    }
}
