<?php

namespace Bame\Http\Requests\Process\ClosingCost;

use Bame\Http\Requests\Request;

class ClosingCostRequest extends Request
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
            'closing_cost' => 'max:500',
        ];
    }
}
