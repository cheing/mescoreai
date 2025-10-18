<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategoryTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['blog_category_id', 'locale', 'name', 'description', 'meta_title', 'meta_description', 'meta_keywords'];

    public function category()
    {
        return $this->belongsTo(BlogCategory::class);
    }
}
