<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
    public function toArray($request) // ✅ no type hint, no return type
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'thumbnail' => $this->thumbnail,
            'thumbnail_url' => $this->thumbnail     
            ? asset('storage/' . $this->thumbnail)
            : null, 
            'user_id' => $this->user_id,
            'author' => new UserResource($this->whenLoaded('author')),
            'published_at' => $this->published_at ? $this->published_at->toDateTimeString() : null,                 
            'status' => $this->status,

            // Include all language translations
            'translations' => $this->whenLoaded('translations', function () {
                return $this->translations->map(function ($t) {
                    return [
                        'locale' => $t->locale,
                        'name' => $t->name,
                        'short_description' => $t->short_description,
                        'content' => $t->content,
                        'meta_title' => $t->meta_title,
                        'meta_description' => $t->meta_description, 
                        'meta_keywords' => $t->meta_keywords,
                    ];
                });
            }),
        ];
    }
}
