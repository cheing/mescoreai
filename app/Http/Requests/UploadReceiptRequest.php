<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadReceiptRequest extends FormRequest
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
            'username' => 'required|string',
            'email' => 'nullable|email',
            'file' => 'nullable|file',
        ];
    }

    public function attributes()
    {
        return [
            'username' => 'me88 Username',
            'email' => 'Email',
            'file' => 'File',
        ];
    }
}
