<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePromotionRequest extends FormRequest
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
            'title_en' => ['required', 'string', 'max:255'],
            'short_description_en' => ['nullable', 'string', 'max:500'],

            'title_zh' => ['required', 'string', 'max:255'],
            'short_description_zh' => ['nullable', 'string', 'max:500'],

            'redirect_url' => ['nullable', 'url'],
            'thumbnail' => ['nullable', 'string'],
            'sort' => ['required', 'integer'],
            'status' => ['required', 'boolean'],
        ];
    }
}
