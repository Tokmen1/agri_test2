<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FieldListRequest extends FormRequest
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
        $sortFieldsWhiteList = [
            'id',
            'field_name',
            'area',
            'created_at',
            'updated_at'
        ];
        return [
            'sort_field' => ['nullable', Rule::in($sortFieldsWhiteList)],
            'sort_order' => ['nullable', Rule::in(['asc', 'desc'])],
            'search' => ['nullable', 'string', 'min:1', 'max:150'],
        ];
    }
}
