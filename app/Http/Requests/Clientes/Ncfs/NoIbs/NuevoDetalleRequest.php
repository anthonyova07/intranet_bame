<?php

namespace Bame\Http\Requests\Clientes\Ncfs\NoIbs;

use Bame\Http\Requests\Request;

class NuevoDetalleRequest extends Request
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
            'descripcion' => 'required',
            'monto' => 'required|numeric',
            'dia' => 'required|integer|between:1,31',
            'mes' => 'required|integer|between:1,12',
            'anio' => 'required|integer|between:2015,' . (new \DateTime)->format('Y'),
        ];
    }
}
