<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InquiriesRequest extends FormRequest
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
            // 'regex:/^[a-zA-Z ]*$/' = uppercase, lowercase, whitespace
            'name' => ['required', 'regex:/^[a-zA-Z ]*$/', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            // 'regex:/^[09]{2}[0-9]{9}+$/' = must start with 09 then, 9 integer
            'phone' => ['required', 'regex:/^[09]{2}[0-9]{9}+$/', 'max:255'],
            'message' => ['required', 'max:255'],
        ];
    }

    protected function prepareForValidation(){
        $this->merge([
            'name' => strip_tags($this['name']),
            'email' => strip_tags($this['email']),
            'phone' => strip_tags($this['phone']),
            'message' => strip_tags($this['message']),
        ]);
    }
}
