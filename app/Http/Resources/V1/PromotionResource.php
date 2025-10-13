<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class PromotionResource extends JsonResource
{
    public function toArray($request) // ✅ no type hint, no return type
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'redirect_url' => $this->redirect_url,
            'thumbnail' => $this->thumbnail,
            'thumbnail_url' => $this->thumbnail
                ? asset('storage/' . $this->thumbnail)
                : null,
            'sort' => $this->sort ? $this->sort : null,
            'status' => $this->status,

            // Include all language translations
            'translations' => $this->whenLoaded('translations', function () {
                return $this->translations->map(function ($t) {
                    return [
                        'locale' => $t->locale,
                        'title' => $t->title,
                        'short_description' => $t->short_description,
                    ];
                });
            }),
        ];
    }
}
