<?php

namespace Bame\Http\Requests\Customer;

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
        return [
            //
        ];
    }
}
