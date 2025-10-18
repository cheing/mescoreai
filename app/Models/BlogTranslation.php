<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'blog_id',
        'locale',
        'title',
        'short_description',
        'content',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }
}
