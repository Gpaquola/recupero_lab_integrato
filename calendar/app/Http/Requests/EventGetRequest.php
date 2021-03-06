<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventGetRequest extends FormRequest
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
            'id' => 'digits',
            'name ' => 'string',
            'note' => 'string|nullable',
            'begin' => 'date_format:Y-m-d H:i:s',
            'end' => 'date_format:Y-m-d H:i:s',
            'priority ' => 'digits:1'
        ];
    }
}
