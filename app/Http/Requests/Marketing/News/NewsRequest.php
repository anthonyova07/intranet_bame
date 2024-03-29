<?php

namespace Bame\Http\Requests\Marketing\News;

use Bame\Http\Requests\Request;

class NewsRequest extends Request
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
            'title' => 'required_if:type,C|required_if:type,N|max:150',
            'type' => 'required|in:C,N,B',
            'detail' => 'max:20000',
            'image' => 'image',
            'image_banner' => 'image' . ($this->news ? '':'|required'),
            // 'link' => 'url',
            // 'link_video' => 'url',
        ];
    }
}
