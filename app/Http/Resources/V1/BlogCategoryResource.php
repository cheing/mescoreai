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
            'sort' => $this->sort ? $this->sort : null,
            'status' => $this->status,

            // Include all language translations
            'translations' => $this->whenLoaded('translations', function () {
                return $this->translations->map(function ($t) {
                    return [
                        'locale' => $t->locale,
                        'title' => $t->title,
                        'description' => $t->description,
                        'meta_title' => $t->meta_title,
                        'meta_description' => $t->meta_description, 
                        'meta_keywords' => $t->meta_keywords,
                    ];
                });
            }),
        ];
    }
}
