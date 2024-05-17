<?php

namespace App\Http\Resources\V1;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class CountryResource extends JsonResource
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
            'code' => $this->code ? $this->code : null,
            'name' => $this->name ? $this->name : null,
            'name_zh' => $this->name_zh ? $this->name_zh : null,
            'flag' => $this->code ? 'flag-icon-'.strtolower($this->code) : null,
            // 'flag' => $this->flag ? $this->flag : null,
            // 'flag_url' => $this->flag ? Storage::disk('public')->url($this->flag) : null,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
            'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d'),
        ];
    }
}
