<?php

namespace Bame\Http\Requests\Marketing\FAQs;

use Bame\Http\Requests\Request;

class FAQsRequest extends Request
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
            'question' => 'required|max:500',
            'answer' => 'required|max:1000',
        ];
    }
}
