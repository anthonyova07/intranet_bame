<?php

namespace Bame\Http\Requests\Clientes;

use Bame\Http\Requests\Request;

class NcfRequest extends Request
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
            'codigo_cliente' => 'numeric',
            'producto' => 'numeric',
            'mes_proceso' => 'numeric|between:1,12',
            'anio_proceso' => 'numeric|between:2015,' . (new \Datetime)->format('Y'),
            'ncf' => 'alpha_num|min:19|max:19',
        ];
    }
}
