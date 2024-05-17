<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest {
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'username' => 'required|max:50',
            'password' => 'required|max:50',
        ];
    }

    public function attributes() {
        return [
            'username' => 'Username',
            'password' => 'Password',
        ];
    }


}
