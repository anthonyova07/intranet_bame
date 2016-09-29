<?php

namespace Bame\Http\Requests\Marketing\Event;

use Bame\Http\Requests\Request;

class EventRequest extends Request
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
            'detail' => 'required|max:10000',
            'image' => 'image' . ($this->event ? '':'|required'),
            'start_event' => 'required|date_format:"Y-m-d\TH:i"',
            'end_subscriptions' => 'required|date_format:"Y-m-d"',
            'number_persons' => 'required_if:limit_persons,on|integer|min:1',
            'number_companions' => 'required_if:limit_persons,on|integer|min:0',
        ];
    }
}
