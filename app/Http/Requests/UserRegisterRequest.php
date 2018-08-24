<?php

namespace CodeFlix\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
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
            'name' => 'required_if:type,2|max:255',
            'email' => 'required_if:type,2|unique:users,email',
            'password' => 'required_if:type,2|min:6|max:16|confirmed'
        ];
    }
}
