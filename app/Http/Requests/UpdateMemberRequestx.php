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
            // 'username' => 'sometimes|required|max:50|unique:users,username',
            // 'name' => 'sometimes|required|max:255',
            'email' => 'sometimes|required|max:25',
            'phone' => 'sometimes|nullable|max:50',
            'status' => 'sometimes|required',
            'subscribe' => 'sometimes|boolean',
            'me88username' => 'sometimes|nullable',
        ];
    }

    public function attributes()
    {
        return [
            'username' => 'Username',
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'status' => 'Status',
            'subscribe' => 'Subscribe',
            'me88username' => 'me88 Username',
        ];
    }
}
