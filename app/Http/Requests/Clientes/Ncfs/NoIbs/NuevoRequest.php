<?php

namespace Bame\Http\Requests\Clientes\Ncfs\NoIbs;

use Bame\Http\Requests\Request;

class NuevoRequest extends Request
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
            'nombres_apellidos' => 'required',
            'tipo_identificacion' => 'required',
            'identificacion' => 'required|alpha_num',
            'mes' => 'required|integer|between:1,12',
            'anio' => 'required|integer|between:2015,' . (new \DateTime)->format('Y'),
        ];
    }
}
