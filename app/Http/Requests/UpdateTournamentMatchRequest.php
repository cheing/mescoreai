<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTournamentMatchRequest extends FormRequest
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
            'tournament_id' => 'sometimes|required|integer',
            'start_time' => 'sometimes|required|date_format:Y-m-d H:i',
            'status' => 'sometimes|required|integer',
            'team_a_id' => 'sometimes|required|integer',
            'team_b_id' => 'sometimes|required|integer',
            'status' => 'sometimes|required|integer',
            'team_a_result' => 'sometimes|nullable|string',
            'team_b_result' => 'sometimes|nullable|string',
            'first_odd' => 'sometimes|nullable|numeric',
            'x_odd' => 'sometimes|nullable|numeric',
            'second_odd' => 'sometimes|nullable|numeric',
            'tip' => 'sometimes|nullable|string',
            'tip_odd' => 'sometimes|nullable|numeric',
            'handicap' => 'sometimes|nullable|string',
            'handicap_odd' => 'sometimes|nullable|numeric',
            'o_u' => 'sometimes|nullable|string',
            'o_u_odd' => 'sometimes|nullable|numeric',
            'correct_score' => 'sometimes|nullable|string',
            'correct_score_odd' => 'sometimes|nullable|numeric',
            'best_tip' => 'sometimes|nullable|string',
            'best_tip_odd' => 'sometimes|nullable|numeric',
            'mixparlay' => 'sometimes|nullable|string',

        ];
    }
}
