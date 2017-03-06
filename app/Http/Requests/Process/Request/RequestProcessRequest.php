<?php

namespace Bame\Http\Requests\Process\Request;

use Bame\Http\Requests\Request;

class RequestProcessRequest extends Request
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
            'request_type' => 'required',
            'process' => 'required',
            'description' => 'required|max:1000',
            'cause_analysis' => 'required|max:1000',
            'people_involved' => 'required|max:1000',
        ];
    }
}
