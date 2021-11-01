<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FieldRequest extends FormRequest
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
            'field_name' => ['required', 'string', 'max:32'],
            'area' => ['required', 'numeric'],
            'created_at' =>[],
            'updated_at' =>[]
            // 'surname' => ['required', 'string', 'max:32'],
            // 'roles' => ['required', 'array'],
            // 'roles.*' => ['required', 'integer', 'exists:roles,id'],
            // 'permissions' => ['nullable', 'array'],
            // 'permissions.*' => ['nullable', 'integer', 'exists:permissions,id'],
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
