<?php

namespace App\Http\Resources\V1;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'username' => $this->username ? $this->username : null,
            'name' => $this->name ? $this->name : null,
            'email ' => $this->email ? $this->email : null,
            'password' => $this->password ? $this->password : null,
            'status' => $this->status ? $this->status : null,
            'phone' => $this->phone ? $this->phone : null,
            'role' => $this->role ? $this->role : null,
            'subscribe' => $this->subscribe ? $this->subscribe : null,
            'me88username' => $this->me88username ? $this->me88username : null,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d'),
            'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d'),
        ];
    }
}
