<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FieldActionsListRequest extends FormRequest
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
            'action_type',
            'cost',
            'date_from',
            'date_to',
            'created_at',
            'updated_at',
            'fields_id',
        ];
        return [
            'sort_field' => ['nullable', Rule::in($sortFieldsWhiteList)],
            'sort_order' => ['nullable', Rule::in(['asc', 'desc'])],
            'thisSpecificField' => ['string', 'min:1', 'max:150'],
            'search' => ['nullable', 'string', 'min:1', 'max:150'],
            
        ];
    }
}
