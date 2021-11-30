<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'id' => ['integer'],
            'name' => ['string'],
            'email' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string'],
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
