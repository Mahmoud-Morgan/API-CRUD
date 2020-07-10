<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Exception;

class RegisterAuthRequest extends FormRequest
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
        
        return [
            'name'     => 'required|string',
            'email'    => 'required|email|unique:users',
            'password' => 'required|string|min:8|max:10'
        ];
       
    }

    // public function messages()
    // {
    //     return [
    //         'email.required' => 'Email is required!',
    //         'name.required' => 'Name is required!',
    //         'password.required' => 'Password is required!'
    //     ];
    // }
}
