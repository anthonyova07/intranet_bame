<?php

namespace Bame\Http\Requests\Customer\Claim;

use Bame\Http\Requests\Request;

class ClaimRequest extends Request
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
            'channel' => 'required',
            'product_type' => 'required',
            'product' => 'required',
            'amount' => 'required|numeric',
            'claim_type' => 'required',
            'response_term' => 'required|integer',
            'response_date' => 'required|date_format:"Y-m-d"',
            'mail' => 'email',
            'observations' => 'max:10000',
        ];
    }
}
