<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePromotionRequest extends FormRequest
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
           // English fields
            'title_en' => ['required', 'string', 'max:255'],
            'short_description_en' => ['nullable', 'string', 'max:500'],

            // Chinese fields
            'title_zh' => ['required', 'string', 'max:255'],
            'short_description_zh' => ['nullable', 'string', 'max:500'],
       
            // Global fields
            'redirect_url' => ['nullable', 'url'],
            'thumbnail' => ['required', 'string'],
            'sort' => 'required|integer',
            'status' => ['required', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'title_en.required' => 'The English title is required.',
            'thumbnail.required' => 'A thumbnail image is required.',
            'thumbnail.image' => 'The thumbnail must be an image file.',
            'redirect_url.url' => 'The redirect URL must be a valid URL.',
        ];
    }
}
