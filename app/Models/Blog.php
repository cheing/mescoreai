<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Blog extends Model
{
    use HasFactory, Sortable;

    protected $fillable = [
        'slug',
        'thumbnail',
        'user_id',
        'status',
        'published_at',
    ];

    public $sortable = ['id', 'status', 'published_at'];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function translations()
    {
        return $this->hasMany(BlogTranslation::class);
    }

    public function translate($locale = null)
    {
        $locale = $locale ?: app()->getLocale();
        return $this->translations->where('locale', $locale)->first();
    }

    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(BlogCategory::class, 'blog_category_pivot');
    }


}
