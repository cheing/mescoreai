<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Promotion extends Model
{
    use HasFactory, Sortable;

    protected $fillable = ['slug', 'thumbnail', 'redirect_url', 'sort', 'status'];

    // Define sortable columns
    public $sortable = ['id', 'status', 'title_en'];

    // Relationship: translations
    public function translations()
    {
        return $this->hasMany(PromotionTranslation::class);
    }

    // Helper to get translation by locale
    public function translate($locale = null)
    {
        $locale = $locale ?: app()->getLocale();
        return $this->translations->where('locale', $locale)->first();
    }

     /**
     * Custom sort for English title.
     */
    public function titleEnSortable($query, $direction)
    {
        // Dynamically get all columns in the promotions table
        $columns = \Schema::getColumnListing('promotions');
        $groupBy = collect($columns)->map(fn($col) => "promotions.$col")->implode(', ');

        return $query
            ->leftJoin('promotion_translations as t_en', function ($join) {
                $join->on('promotions.id', '=', 't_en.promotion_id')
                    ->where('t_en.locale', '=', 'en');
            })
            ->select('promotions.*')
            ->groupByRaw($groupBy)
            ->orderBy('t_en.title', $direction);
    }


    /**
     * Accessors for quick title retrieval
     */    public function getTitleEnAttribute()
    {
        return optional($this->translations->where('locale', 'en')->first())->title;
    }

    public function getTitleZhAttribute()
    {
        return optional($this->translations->where('locale', 'zh')->first())->title;
    }
}
