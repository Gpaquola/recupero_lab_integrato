<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventCreateRequest extends FormRequest
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
            'name' => 'required|string',
            'begin' => 'required|date_format:Y-m-d H:i:s',
            'note' => 'string|nullable',
            'end' => 'date_format:Y-m-d H:i:s',
            'priority ' => 'digits:1',
        ];
    }
}
