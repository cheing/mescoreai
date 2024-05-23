<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTournamentMatchRequest extends FormRequest
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
            'tournament_id' => 'required|integer',
            'start_time' => 'required|date_format:Y-m-d H:i',
            'team_a_id' => 'required|integer',
            'team_b_id' => 'required|integer',
            'status' => 'required|integer',
            'team_a_result' => 'sometimes|nullable|string',
            'team_b_result' => 'sometimes|nullable|string',
            'first_odd' => 'nullable|numeric',
            'x_odd' => 'nullable|numeric',
            'second_odd' => 'nullable|numeric',
            'tip' => 'nullable|string',
            'tip_odd' => 'nullable|numeric',
            'handicap' => 'nullable|string',
            'handicap_odd' => 'nullable|numeric',
            'o_u' => 'nullable|string',
            'o_u_odd' => 'nullable|numeric',
            'correct_score' => 'nullable|string',
            'correct_score_odd' => 'nullable|numeric',
            'best_tip' => 'nullable|string',
            'best_tip_odd' => 'nullable|numeric',
        ];
    }
}
