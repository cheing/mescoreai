<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UserInfoRequest extends FormRequest {
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'id'  => 'required|max:11',
            'name' => 'required|max:50',
            'email' => 'required|max:50',
            'status' => 'required',
        ];
    }

    public function attributes() {
        return [
          'name' => 'Name',
          'email' => 'Email',
          'status' => 'Status'
        ];
    }


}
