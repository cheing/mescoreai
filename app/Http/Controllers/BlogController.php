<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Information;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class BlogController extends Controller
{
     /**
     * Display all blogs (main blog page)
     */
    public function index(Request $request)
    {
        $locale = app()->getLocale();

        // Filter by archive (year-month)
        $archiveFilter = $request->query('archive');

        $query = Blog::with([
            'translations' => fn($q) => $q->where('locale', $locale),
            'categories.translations' => fn($q) => $q->where('locale', $locale),
            'author', 
        ])       
        ->where('status', 1);

        if ($archiveFilter) {
            $query->whereRaw("DATE_FORMAT(published_at, '%Y-%m') = ?", [$archiveFilter]);
        }

        $blogs = $query->orderByDesc('published_at')->paginate(3);

        // Meta Info
        $meta = Information::where('key', 'meta_blogs')->first();

        // Sidebar: All categories
        $allCategories = BlogCategory::with(['translations' => fn($q) => $q->where('locale', $locale)])
            ->where('status', 1)
            ->orderBy('sort')
            ->get();

        // Sidebar: Archives list
        $archives = Blog::selectRaw("DATE_FORMAT(published_at, '%Y-%m') as ym, COUNT(*) as count")
            ->where('status', 1)
            ->groupBy('ym')
            ->orderByDesc('ym')
            ->pluck('count', 'ym');

        return view('blogs.index', compact('blogs', 'meta', 'allCategories', 'archives'));
    }

    /**
     * Display single blog page
     */
    public function show($slug)
    {
        $locale = app()->getLocale();

        $blog = Blog::with([
            'translations' => fn($q) => $q->where('locale', $locale),
            'categories.translations' => fn($q) => $q->where('locale', $locale),
        ])
        ->where('slug', $slug)
        ->where('status', 1)
        ->firstOrFail();

        // Meta
        $meta = (object) [
            'title' => $blog->translate()?->meta_title ?? $blog->translate()?->title,
            'content' => $blog->translate()?->meta_description,
            'keywords' => $blog->translate()?->meta_keywords,
        ];

        // Sidebar
        $allCategories = BlogCategory::with(['translations' => fn($q) => $q->where('locale', $locale)])
            ->where('status', 1)
            ->orderBy('sort')
            ->get();

        $archives = Blog::selectRaw("DATE_FORMAT(published_at, '%Y-%m') as ym, COUNT(*) as count")
            ->where('status', 1)
            ->groupBy('ym')
            ->orderByDesc('ym')
            ->pluck('count', 'ym');

        // Related Posts
        $relatedPosts = Blog::with(['translations' => fn($q) => $q->where('locale', $locale)])
            ->where('id', '!=', $blog->id)
            ->where('status', 1)
            ->whereHas('categories', function ($q) use ($blog) {
                $q->whereIn('blog_category_id', $blog->categories->pluck('id'));
            })
            ->orderByDesc('published_at')
            ->take(4)
            ->get();

        return view('blogs.show', compact('blog', 'meta', 'allCategories', 'archives', 'relatedPosts'));
    }

    /**
     * Display category page
     */
    public function category($slug)
    {
        $locale = app()->getLocale();

        $category = BlogCategory::with([
            'translations' => fn($q) => $q->where('locale', $locale),
            'blogs.translations' => fn($q) => $q->where('locale', $locale),
        ])
        ->where('slug', $slug)
        ->where('status', 1)
        ->firstOrFail();

        $meta = (object) [
            'title' => $category->translate()?->meta_title ?? $category->translate()?->name,
            'content' => $category->translate()?->meta_description,
            'keywords' => $category->translate()?->meta_keywords,
        ];

        // Sidebar
        $allCategories = BlogCategory::with(['translations' => fn($q) => $q->where('locale', $locale)])
            ->where('status', 1)
            ->orderBy('sort')
            ->get();

        $archives = Blog::selectRaw("DATE_FORMAT(published_at, '%Y-%m') as ym, COUNT(*) as count")
            ->where('status', 1)
            ->groupBy('ym')
            ->orderByDesc('ym')
            ->pluck('count', 'ym');

        // Paginate category blogs
        $blogs = $category->blogs()
            ->where('status', 1)
            ->with(['translations' => fn($q) => $q->where('locale', $locale)])
            ->orderByDesc('published_at')
            ->paginate(9);

        return view('blogs.category', compact('category', 'blogs', 'meta', 'allCategories', 'archives'));
    }
}
