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
            'first_odd' => 'nullable|numeric',
            'x_odd' => 'nullable|numeric',
            'second_odd' => 'nullable|numeric',
            'tip' => 'nullable|numeric',
            'tip_odd' => 'nullable|numeric',
            'handicap' => 'nullable|numeric',
            'handicap_odd' => 'nullable|numeric',
            'o_u' => 'nullable|numeric',
            'o_u_odd' => 'nullable|numeric',
            'correct_score' => 'nullable|numeric',
            'correct_score_odd' => 'nullable|numeric',
            'best_tip' => 'nullable|numeric',
            'best_tip_odd' => 'nullable|numeric',
        ];
    }
}
