<?php

namespace Bame\Http\Requests\mantenimientos\menstc;

use Bame\Http\Requests\Request;

class MensajeFormRequest extends Request
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
           'mensaje1'=>'required|max:60',           
           'mensaje2'=>'required|max:60',           
        ];
    }
}
