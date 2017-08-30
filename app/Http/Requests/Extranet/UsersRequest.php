<?php

namespace Bame\Http\Requests\Extranet;

use Bame\Http\Requests\Request;

class UsersRequest extends Request
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
            'business' => 'required',
            'full_name' => 'required|max:45',
            'identification' => 'required|max:45',
            'position' => 'required|max:45',
            'username' => 'required|max:45|alpha',
            'password' => 'confirmed' . ($this->users ? '':'|required'),
        ];
    }
}
