<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePackageRequest extends FormRequest
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
            'sort' => 'required|integer',
            'name' => 'required|string|max:255',
            'status' => 'required|integer|max:1',
            'duration' => 'nullable|integer',
            'display_name.en' => 'required|string|max:255',
            'display_name.zh' => 'required|string|max:255',
            'short_description.en' => 'required|string',
            'short_description.zh' => 'required|string',
            'description.en' => 'required|string',
            'description.zh' => 'required|string',
        ];
    }
}
