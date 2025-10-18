<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            // English fields
            'name_en' => ['required', 'string', 'max:255'],
            'description_en' => ['nullable', 'string', 'max:500'],
            'meta_title_en' => ['nullable', 'string', 'max:255'],
            'meta_description_en' => ['nullable', 'string', 'max:500'],
            'meta_keywords_en' => ['nullable', 'string', 'max:255'],

            // Chinese fields
            'name_zh' => ['required', 'string', 'max:255'],
            'description_zh' => ['nullable', 'string', 'max:500'],
            'meta_title_zh' => ['nullable', 'string', 'max:255'],
            'meta_description_zh' => ['nullable', 'string', 'max:500'],
            'meta_keywords_zh' => ['nullable', 'string', 'max:255'],

            // General
            'sort' => 'nullable|integer',
            'status' => ['required', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'name_en.required' => 'The English title is required.',
            'name_zh.required' => 'The Chinese title is required.',
            'status.required' => 'The status field is required.',
            'status.boolean' => 'The status field must be true or false.',
        ];
    }
}