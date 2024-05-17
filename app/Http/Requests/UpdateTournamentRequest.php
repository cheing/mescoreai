<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTournamentRequest extends FormRequest
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
            'title' => 'sometimes|required|string|max:255',
            'title_zh' => 'sometimes|required|string|max:255',
            'start_date' => 'sometimes|required|date_format:Y-m-d',
            'end_date' => 'sometimes|required|date_format:Y-m-d',
            'status' => 'sometimes|required|integer|max:1',
            'plan' => 'sometimes|nullable|string|max:255',
            'banner' => 'sometimes|nullable|string|max:255',
        ];
    }
}
