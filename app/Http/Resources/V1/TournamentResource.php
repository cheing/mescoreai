<?php

namespace App\Http\Resources\V1;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class TournamentResource extends JsonResource
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
            'title' => $this->title ? $this->title : null,
            'title_zh' => $this->title_zh ? $this->title_zh : null,
            'start_date' => Carbon::parse($this->start_date)->format('Y-m-d'),
            'end_date' => Carbon::parse($this->end_date)->format('Y-m-d'),
            'status' => $this->status ? $this->status : null,
            // 'plan' => $this->plan ? $this->plan : null,
            // 'plan_url' => $this->plan ? Storage::disk('public')->url($this->plan) : null,
            // 'banner' => $this->banner ? $this->banner : null,
            // 'banner_url' => $this->banner ? Storage::disk('public')->url($this->banner) : null,
            'matches' => MatchResource::collection($this->whenLoaded('matches')),
            'created_at' => Carbon::parse($this->created_at)->format('d-m-Y'),
            'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d'),
        ];
    }
}
