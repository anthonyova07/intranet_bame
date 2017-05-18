<?php

namespace Bame\Http\Requests\HumanResource\Request;

use Bame\Http\Requests\Request;

class RequestHumanResourceRequest extends Request
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
        $v = [
            'colsupuser' => 'required',
        ];

        if ($this->type == 'PERAUS') {
            $v = array_merge($v, [
                'permission_type' => 'required',
                'peraus' => 'required',
                'peraus_reason' => 'required_if:peraus,otro|max:1000',
            ]);

            if ($this->permission_type == 'one_day') {
                $v = array_merge($v, [
                    'permission_date' => 'required|date_format:"Y-m-d',
                    'permission_time_from' => 'required|date_format:"H:i',
                    'permission_time_to' => 'required|date_format:"H:i',
                ]);
            }

            if ($this->permission_type == 'multiple_days') {
                $v = array_merge($v, [
                    'permission_date_from' => 'required|date_format:"Y-m-d',
                    'permission_date_to' => 'required|date_format:"Y-m-d',
                ]);
            }
        }

        if ($this->type == 'VAC') {
            $v = array_merge($v, [
                // 'vac_date_admission' => 'required|date_format:"Y-m-d',
                'vac_date_from' => 'required|date_format:"Y-m-d',
                // 'vac_date_to' => 'required|date_format:"Y-m-d',
                'vac_total_days' => 'required|integer|min:1|max:18',
                'vac_total_pending_days' => 'required|integer|min:0|max:18',
                'note' => 'max:1000',
            ]);
        }

        return $v;
    }

    public function messages() {
        return [
            'permission_type.required' => 'Debe seleccionar un tipo de permiso',
            'peraus.required' => 'Debe seleccionar una razón de la ausencia',
            'peraus_reason.required_if' => 'Debe especificar el motivo de la ausencia.',
        ];
    }
}
