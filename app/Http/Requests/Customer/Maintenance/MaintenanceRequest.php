<?php

namespace Bame\Http\Requests\Customer\Maintenance;

use Bame\Http\Requests\Request;

class MaintenanceRequest extends Request
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
        if ($this->core == 'ibs') {
            return [
                //
            ];
        }

        if ($this->core == 'itc') {
            return [
                'mail_itc' => 'required_if:ways_sending_statement_itc,6|email',
                'mail_2_itc' => 'required_if:ways_sending_statement_2_itc,6|email',
            ];
        }
    }

    public function messages()
    {
        return [
            'mail_itc.required_if' => 'El campo Correo Electrónico es requerido cuando la forma de envió es Correo Electrónico.',
            'mail_itc.email' => 'El campo Correo Electrónico no corresponde con una dirección de e-mail válida.',
            'mail_2_itc.required_if' => 'El campo Correo Electrónico es requerido cuando la forma de envió es Correo Electrónico.',
            'mail_2_itc.email' => 'El campo Correo Electrónico no corresponde con una dirección de e-mail válida.',
        ];
    }
}
