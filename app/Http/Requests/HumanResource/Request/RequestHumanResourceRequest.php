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
        $v = [];

        if (in_array($this->type, ['PER', 'VAC'])) {
            $v = array_merge($v, [
                'colsupuser' => 'required',
            ]);
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

        if ($this->type == 'ANT') {
            $v = array_merge($v, [
                'identification' => 'required',
                'ant_account_number' => 'required',
                'ant_amount' => 'required|integer|min:1',
                'ant_dues' => 'required|integer|min:1|max:12',
            ]);
        }

        if (in_array($this->type, ['PER', 'AUS'])) {
            $v = array_merge($v, [
                'permission_type' => 'required',
                'per' => 'required',
                'per_reason' => 'required_if:per,otro|max:1000',
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

        return $v;
    }

    public function messages() {
        return [
            'permission_type.required' => 'Debe seleccionar un tipo de permiso',
            'per.required' => 'Debe seleccionar una razón de la ausencia',
            'per_reason.required_if' => 'Debe especificar el motivo de la ausencia.',
        ];
    }
}
