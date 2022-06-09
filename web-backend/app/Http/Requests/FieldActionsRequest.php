<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FieldActionsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'id' => ['integer'],
            'action_type' => ['required', 'string', 'max:32'],
            'cost' => ['numeric'],
            'date_from' => ['required'],
            'date_to' =>[],
            'created_at' =>[],
            'updated_at' =>[],
            'user_id' => ['integer'],
            'fields_id' => ['required','integer']
        ];
        if ($this->isMethod('post')) {
            // $rules['is_active'] = ['required', 'boolean'];
            // $rules['email'] = ['required', 'string', 'email', 'max:64', 'unique:users'];
            // $rules['password'] = ['required', 'string', 'min:6', 'max:64', 'confirmed'];
        }
        if ($this->isMethod('put')) {
            // $rules['email'] = ['required', 'string', 'email', 'max:64', Rule::unique('users')->ignore($this->user->id)];
        }
        return $rules;
    }
}
