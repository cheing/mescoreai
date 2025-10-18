<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBlogRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            // English fields
            'title_en' => ['required', 'string', 'max:255'],
            'short_description_en' => ['nullable', 'string', 'max:500'],
            'content_en' => ['nullable', 'string'],
            'meta_title_en' => ['nullable', 'string', 'max:255'],
            'meta_description_en' => ['nullable', 'string', 'max:500'],
            'meta_keywords_en' => ['nullable', 'string', 'max:255'],

            // Chinese fields
            'title_zh' => ['nullable', 'string', 'max:255'],
            'short_description_zh' => ['nullable', 'string', 'max:500'],
            'content_zh' => ['nullable', 'string'],
            'meta_title_zh' => ['nullable', 'string', 'max:255'],
            'meta_description_zh' => ['nullable', 'string', 'max:500'],
            'meta_keywords_zh' => ['nullable', 'string', 'max:255'],

            // General
            'thumbnail' => ['nullable', 'string'],
            'status' => ['required', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'title_en.required' => 'The English title is required.',
            'thumbnail.mimes' => 'The thumbnail must be an image (JPG, PNG, or WEBP).',
            'thumbnail.max' => 'The thumbnail image may not be greater than 2MB.',
            'status.required' => 'The status field is required.',
            'status.boolean' => 'The status field must be true or false.',
        ];
    }
}