<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMemberRequest extends FormRequest
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
            // 'username' => 'required|max:50|unique:users,username',
            'email' => 'required|max:255|email',
            'phone' => 'nullable|max:50',
            'status' => 'required',
            'subscribe' => 'boolean',
            'me88username' => 'nullable',
        ];
    }

    public function attributes()
    {
        return [
            // 'username' => 'Username',
            // 'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',

            'status' => 'status',
            // 'password' => 'Password',
            // 'password_confirmation' => 'Confirm Password',
            'subscribe' => 'Subscribe',
            'me88username' => 'me88 Username',
        ];
    }
}
