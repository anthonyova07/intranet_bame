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
            'title' => 'required|max:150',
            'type' => 'required|in:C,N,B',
            'detail' => 'required|max:20000',
            'image' => 'image' . ($this->FAQs ? '':'|required'),
            // 'link' => 'url',
            // 'link_video' => 'url',
        ];
    }
}
