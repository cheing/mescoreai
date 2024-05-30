<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFAQRequest extends FormRequest
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
            'sort' => 'sometimes|required|integer',
            'title' => 'sometimes|required|string',
            'title_zh' => 'sometimes|required|string',
            'content' => 'sometimes|required|string',
            'content_zh' => 'sometimes|required|string',
        ];
    }
}
