<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    use HasFactory;

    protected $fillable = ['slug', 'status', 'sort'];

    public function translations()
    {
        return $this->hasMany(BlogCategoryTranslation::class);
    }

    public function translate($locale = null)
    {
        $locale = $locale ?: app()->getLocale();
        return $this->translations->where('locale', $locale)->first();
    }

    public function blogs()
    {
        return $this->belongsToMany(Blog::class, 'blog_category_pivot');
    }

}