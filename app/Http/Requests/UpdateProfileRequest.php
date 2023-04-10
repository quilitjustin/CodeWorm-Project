<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
        $this->rule = $this->request->get('action');

        if ($this->rule == 'picture') {
            return [
                'image' => ['required', 'mimes:jpg,png,jpeg', 'max:5048'],
                'action' => ['required', 'in:picture'],
            ];
        }

        if ($this->rule == 'details') {
            $this->uid = decrypt($this->request->get('id'));

            return [
                // 'image' => ['required', 'mimes:jpg,png,jpeg', 'max:5048'],
                'f-name' => ['required', 'regex:/^[a-zA-Z ]*$/', 'max:255'],
                'l-name' => ['required', 'regex:/^[a-zA-Z ]*$/', 'max:255'],
                'm-name' => ['required', 'regex:/^[a-zA-Z ]*$/', 'max:255'],
                'email' => [
                    'required',
                    'email',
                    \Illuminate\Validation\Rule::unique('users')->ignore($this->uid),
                    'max:255',
                    function ($attribute, $value, $fail) {
                        if (!strpos($value, '.')) {
                            $fail('The email must have a valid top-level domain.');
                        }
                    },
                ],
                'action' => ['required', 'in:details'],
            ];
        }

        if ($this->rule == 'password') {
            return [
                'old_password' => [
                    'required',
                    function ($attribute, $value, $fail) {
                        if (!\Illuminate\Support\Facades\Hash::check($this->request->get('old_password'), \Illuminate\Support\Facades\Auth::user()->password)) {
                            $fail('The old password does not match.');
                        }
                    },
                ],
                'password' => ['required', 'confirmed', 'min:8'],
                'password_confirmation' => ['required'],
                'action' => ['required', 'in:password'],
            ];
        }

        //Return an 404 if action has been modified
        abort(404);
    }

    protected function prepareForValidation()
    {
        if ($this->rule == 'picture') {
            $this->merge([
                'action' => strip_tags($this['action']),
            ]);
        }
        if ($this->rule == 'details') {
            $this->merge([
                'f-name' => strip_tags($this['f-name']),
                'l-name' => strip_tags($this['l-name']),
                'm-name' => strip_tags($this['m-name']),
                'email' => strip_tags($this['email']),
                'action' => strip_tags($this['action']),
            ]);
        }
        if ($this->rule == 'password') {
            $this->merge([
                'password' => strip_tags($this['password']),
                'action' => strip_tags($this['action']),
            ]);
        }
    }
}
