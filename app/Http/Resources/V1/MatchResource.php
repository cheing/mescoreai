<?php

namespace App\Http\Resources\V1;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class MatchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id ? $this->id : null,
            'tournament_id' => $this->tournament_id ? $this->tournament_id : null,
            // 'start_time' => $this->start_time ? Carbon::parse($this->start_time)->format('Y-m-d H:i') : null,
            'start_time' => $this->start_time->format('Y-m-d H:i') ?? null,
            'team_a_id' => $this->team_a_id ? $this->team_a_id : null,
            'team_a' => $this->teamA->name ? $this->teamA->name : null,
            'team_a_image_url' => $this->teamA->image ? Storage::disk('public')->url($this->teamA->image) : null,
            'team_b_id' => $this->team_b_id ? $this->team_b_id : null,
            'team_b' => $this->teamB->name ? $this->teamB->name : null,
            'team_b_image_url' => $this->teamB->image ? Storage::disk('public')->url($this->teamB->image) : null,
            'status' => $this->status ? $this->status : null,
            'first_odd' => $this->first_odd ? $this->first_odd : null,
            'x_odd' => $this->x_odd ? $this->x_odd : null,
            'second_odd' => $this->second_odd ? $this->second_odd : null,
            'tip' => $this->tip ? $this->tip : null,
            'tip_odd' => $this->tip_odd ? $this->tip_odd : null,
            'handicap' => $this->handicap ? $this->handicap : null,
            'handicap_odd' => $this->handicap_odd ? $this->handicap_odd : null,
            'o_u' => $this->o_u ? $this->o_u : null,
            'o_u_odd' => $this->o_u_odd ? $this->o_u_odd : null,
            'correct_score' => $this->correct_score ? $this->correct_score : null,
            'correct_score_odd' => $this->correct_score_odd ? $this->correct_score_odd : null,
            'best_tip' => $this->best_tip ? $this->best_tip : null,
            'best_tip_odd' => $this->best_tip_odd ? $this->best_tip_odd : null,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
            'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d'),
        ];
    }
}
