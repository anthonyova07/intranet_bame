<?php

namespace Bame\Http\Requests\Event;

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
            'end_event' => 'required|after:'.$this->start_event.'|date_format:"Y-m-d\TH:i"',
            'end_subscriptions' => 'required|before:'.$this->end_event.'||date_format:"Y-m-d\TH:i"',
            'number_persons' => 'required_if:limit_persons,on|integer',
            'number_companions' => 'required_if:limit_companions,on|integer',
        ];
    }
}
