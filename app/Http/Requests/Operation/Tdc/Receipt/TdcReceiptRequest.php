<?php

namespace Bame\Http\Requests\Operation\Tdc\Receipt;

use Bame\Http\Requests\Request;

class TdcReceiptRequest extends Request
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
            'identification' => 'alpha_dash',
            'credit_card' => 'alpha_dash|min:16|max:16',
            'date' => 'date_format:"Y-m-d"',
        ];
    }
}
