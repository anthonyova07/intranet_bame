<?php

namespace Bame\Http\Requests\Treasury\Rates;

use Bame\Http\Requests\Request;

class ProductRequest extends Request
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
            'name' => 'required|max:100',
            'rate_type' => 'required|in:' . get_treasury_rate_types()->keys()->implode(','),
            'content' => 'required|in:' . get_treasury_rate_contents()->keys()->implode(','),
        ];
    }
}
