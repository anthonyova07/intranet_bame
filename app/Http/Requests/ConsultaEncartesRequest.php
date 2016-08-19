<?php

namespace Bame\Http\Requests;

use Bame\Http\Requests\Request;

class ConsultaEncartesRequest extends Request
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
            'identificacion' => '',
            'tarjeta' => 'alpha_dash|min:16|max:19',
            'fecha' => 'date_format:"Y-m-d"|min:8|max:10',
        ];
    }
}
