<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //
            'f-name' => ['required', 'regex:/^[a-zA-Z ]*$/', 'max:255'],
            'l-name' => ['required', 'regex:/^[a-zA-Z ]*$/', 'max:255'],
            'm-name' => ['required', 'regex:/^[a-zA-Z ]*$/', 'max:255'],
            'email' => ['required', 'email', 'unique:users', 'max:255'],
            'role' => ['required', 'in:admin,user'],
            //confirmed-password
            'password' => ['required', 'confirmed', 'min:8'],
            'password_confirmation' => ['required'],
        ];
    }

    protected function prepareForValidation(){
        $this->merge([
            'f-name' => strip_tags($this['f-name']),
            'l-name' => strip_tags($this['l-name']),
            'm-name' => strip_tags($this['m-name']),
            'email' => strip_tags($this['email']),
            'role' => strip_tags($this['role']),
            'password' => strip_tags($this['password']),
        ]);
    }
}
