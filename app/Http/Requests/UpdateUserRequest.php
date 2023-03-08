<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
        $id = strip_tags($this->request->get('id'));
        
        if($this->rule == 'details'){
            return [
                //
                'f-name' => ['required', 'regex:/^[a-zA-Z ]*$/'],
                    'l-name' => ['required', 'regex:/^[a-zA-Z ]*$/'],
                    'm-name' => ['required', 'regex:/^[a-zA-Z ]*$/'],
                    'email' => ['required', 'email', \Illuminate\Validation\Rule::unique('users')->ignore($id)],
                    'role' => ['required', 'in:admin,user'],
                    'action' => ['required', 'in:details'],
            ];
        }

        if($this->rule == 'password'){
            return [
                'password' => ['required', 'confirmed', 'min:8'],
                'password_confirmation' => ['required'],
                'action' => ['required', 'in:password'],
            ];
        }

        //Return an 404 if action has been modified
        abort(404);
    }

    protected function prepareForValidation(){
        if($this->rule == 'details'){
            $this->merge([
                'f-name' => strip_tags($this['f-name']),
                'l-name' => strip_tags($this['l-name']),
                'm-name' => strip_tags($this['m-name']),
                'email' => strip_tags($this['email']),
                'action' => strip_tags($this['action']),
            ]);
        }
        if($this->rule == 'password'){
            $this->merge([
                'password' => strip_tags($this['password']),
                'action' => strip_tags($this['action']),
            ]);
        }
    }
}
