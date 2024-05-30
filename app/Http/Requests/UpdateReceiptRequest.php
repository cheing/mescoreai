<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReceiptRequest extends FormRequest
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
            'user_id' => 'sometimes|required|integer',
            'username' => 'sometimes|required|string',
            'email' => 'sometimes|nullable|email',
            'file_path' => 'sometimes|nullable|string',
        ];
    }
}
