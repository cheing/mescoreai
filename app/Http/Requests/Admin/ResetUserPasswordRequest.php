<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ResetUserPasswordRequest extends FormRequest {
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'id' => 'required',
            'password' => 'required|min:8|max:50',
            'password2' => 'required|min:8|max:50|same:password',
        ];
    }

    public function attributes() {
        return [
            'id' => 'User ID',
            'password' => 'Password',
            'password2' => 'Confirm Password'
        ];
    }
}
