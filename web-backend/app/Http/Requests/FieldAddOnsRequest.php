<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FieldAddOnsRequest extends FormRequest
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
            'type' => ['required', 'string'],
            'name' => ['required', 'string'],
            'amount_per_ha' => ['required', 'numeric'],
            'date_from' => ['required'],
            'date_to' =>[],
            'created_at' =>[],
            'updated_at' =>[],
            'field_id' => ['required','integer']
        ];
    }
}
