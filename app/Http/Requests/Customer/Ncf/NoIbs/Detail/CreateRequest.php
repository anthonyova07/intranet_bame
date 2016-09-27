<?php

namespace Bame\Http\Requests\Customer\Ncf\NoIbs\Detail;

use Bame\Http\Requests\Request;

class CreateRequest extends Request
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
            'description' => 'required|max:50',
            'amount' => 'required|numeric',
            'day' => 'required|integer|between:1,31',
            'month' => 'required|integer|between:1,12',
            'year' => 'required|integer|between:2015,' . (new \DateTime)->format('Y'),
        ];
    }
}
