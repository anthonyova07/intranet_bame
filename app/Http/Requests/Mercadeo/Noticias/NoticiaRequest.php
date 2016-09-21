<?php

namespace Bame\Http\Requests\Mercadeo\Noticias;

use Bame\Http\Requests\Request;

class NoticiaRequest extends Request
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
            'detail' => 'required|max:10000',
            'image' => 'image|size:2048' . ($this->id ? '':'|required'),
        ];
    }
}
