<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePageRequest extends FormRequest
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
            'content_en' => ['nullable', 'string'],
            'meta_title_en' => ['nullable', 'string', 'max:255'],
            'meta_description_en' => ['nullable', 'string', 'max:500'],
            'meta_keywords_en' => ['nullable', 'string', 'max:255'],

            // Chinese fields
            'title_zh' => ['required', 'string', 'max:255'],
            'content_zh' => ['nullable', 'string'],
            'meta_title_zh' => ['nullable', 'string', 'max:255'],
            'meta_description_zh' => ['nullable', 'string', 'max:500'],
            'meta_keywords_zh' => ['nullable', 'string', 'max:255'],

            // General
            'sort' =>  ['required', 'integer'],
            'status' => ['required', 'boolean'],
            'menu_position' => ['required', 'string'],
        ];
    }
}
