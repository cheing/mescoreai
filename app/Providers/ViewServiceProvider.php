<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\BlogCategory;
use App\Models\Blog;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{

    public function boot()
    {
        View::composer('frontend.blogs.*', function ($view) {
            $locale = app()->getLocale();

            $categories = BlogCategory::with(['translations' => fn($q) => $q->where('locale', $locale)])
                ->where('status', 1)
                ->orderBy('sort')
                ->get();

            $archives = Blog::selectRaw("DATE_FORMAT(published_at, '%Y-%m') as ym, COUNT(*) as count")
                ->where('status', 1)
                ->groupBy('ym')
                ->orderByDesc('ym')
                ->pluck('count', 'ym');

            $view->with(compact('categories', 'archives'));
        });
    }

}