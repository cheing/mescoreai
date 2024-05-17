<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest {
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'id'  => 'required',
            'name' => 'required|max:50',
            'email' => 'required|max:50',
        ];
    }

    public function attributes() {
        return [
            'name' => 'Name',
            'email' => 'Email',
        ];
    }


}
