<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SowingRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => ['integer'],
            'name' => ['required', 'string', 'max:30'],
            'breed' => ['required', 'string', 'max:50'],
            'pre_plant' => ['required', 'string', 'max:50'],
            'sowing_rate' => ['required', 'numeric'],
            'date_from' => ['required'],
            'date_to' =>[],
            'user_id' => ['integer'],
            'field_id' => ['required','integer']
        ];
    }
}
