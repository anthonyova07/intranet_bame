<?php

namespace Bame\Http\Requests\Cumplimiento\Cliente;

use Bame\Http\Requests\Request;

class CumstFormRequest extends Request
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
            'nombre'=>'required|max:45',
            'primernombre'=>'required|max:30',    
            'segundonombre'=>'max:30',  
            'primerapellido'=>'required|max:30',    
            'segundoapellido'=>'max:30',              
            'dia'=>'required|max:2',              
            'mes'=>'required|max:2',              
            'anio'=>'required|max:4',              
        ];
    }
}
