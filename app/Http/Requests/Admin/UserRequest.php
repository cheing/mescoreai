<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest {
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'username' => 'required|max:50|unique:users',
            'name' => 'required|max:50',
            'email' => 'required|max:255|unique:users',
            'status' => 'required',
            'password' => 'required|min:8|max:50',
            'password2' => 'required|min:8|max:50|same:password',
        ];
    }

    public function attributes() {
        return [
            'username' => 'Username',
            'name' => 'Name',
            'email' => 'Email',
            'status' => 'Status',
            'password' => 'Password',
            'password2' => 'Confirm Password'
        ];
    }


}
