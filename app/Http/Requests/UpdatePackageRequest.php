<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePackageRequest extends FormRequest
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
            'name' => 'sometimes|required|string|max:255',
            'status' => 'sometimes|required|integer|max:1',
            'duration' => 'sometimes|nullable|integer',
            'display_name.en' => 'sometimes|required|string|max:255',
            'display_name.zh' => 'sometimes|required|string|max:255',
            'short_description.en' => 'sometimes|nullable|string',
            'short_description.zh' => 'sometimes|nullable|string',
            'description.en' => 'sometimes|nullable|string',
            'description.zh' => 'sometimes|nullable|string',
        ];
    }
}
