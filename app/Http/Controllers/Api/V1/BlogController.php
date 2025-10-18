<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogTranslation;
use App\Models\BlogCategory;    
use App\Models\BlogCategoryTranslation;   
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    private $limits = 15;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sort = $request->input('sort', 'id');
        $direction = $request->input('direction', 'desc');

        // $query = Blog::with(['translations' => function ($q) {
        //     $q->where('locale', 'en');
        // }]);

        

        $query = Blog::with([
            'translations' => fn($q) => $q->where('locale', 'en'),
            'categories.translations' => fn($q) => $q->where('locale', 'en')
        ]);

        if ($request->filled('category_id')) {
            $query->whereHas('categories', fn($q) => $q->where('blog_categories.id', $request->category_id));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($sort === 'title_en') {
            $query->leftJoin('blog_translations as t_en', function ($join) {
                $join->on('blogs.id', '=', 't_en.blog_id')
                     ->where('t_en.locale', '=', 'en');
            })->orderBy('t_en.title', $direction)
              ->select('blogs.*');
        } else {
            $query->orderBy($sort, $direction);
        }

        $blogs = $query->paginate($this->limits);

        $statuses = \Config::get('custom')['statuses'];

        $categories = BlogCategory::with(['translations' => function ($q) {
            $q->where('locale', 'en');
        }])->orderBy('id')->get();

        return view('admin.blogs.index',[
            'blogs' => $blogs,
            'statuses' => $statuses,
            'categories' => $categories,
            
        ]); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $statuses = \Config::get('custom')['statuses'];
        $languages = [
            ['code' => 'en', 'flag' => 'gb', 'name' => 'English'],
            ['code' => 'zh', 'flag' => 'cn', 'name' => '中文'],
        ];
        $categories = BlogCategory::with(['translations' => function ($q) {
            $q->where('locale', 'en');
        }])->orderBy('id')->get();

        return view('admin.blogs.create', [
            'languages' => $languages,
            'statuses' => $statuses,
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource.
     */
    public function store(StoreBlogRequest $request)
    {
        $data = $request->validated();

        $blog = DB::transaction(function () use ($request, $data) {
            // Create main record
            $blog = Blog::create([
                'slug' => Str::slug($data['title_en']),
                'thumbnail' => $data['thumbnail'] ?? null,
                'status' => (bool) $data['status'],
                'user_id' => auth()->id() ?? null,
                'published_at' => now(),
            ]);

            // Create translations
            $blog->translations()->createMany([
                [
                    'locale' => 'en',
                    'title' => $data['title_en'],
                    'short_description' => $data['short_description_en'] ?? null,
                    'content' => $data['content_en'] ?? null,
                    'meta_title' => $data['meta_title_en'] ?? null,
                    'meta_description' => $data['meta_description_en'] ?? null,
                    'meta_keywords' => $data['meta_keywords_en'] ?? null,
                ],
                [
                    'locale' => 'zh',
                    'title' => $data['title_zh'] ?? null,
                    'short_description' => $data['short_description_zh'] ?? null,
                    'content' => $data['content_zh'] ?? null,
                    'meta_title' => $data['meta_title_zh'] ?? null,
                    'meta_description' => $data['meta_description_zh'] ?? null,
                    'meta_keywords' => $data['meta_keywords_zh'] ?? null,
                ],
            ]);

            // Update Category
            $blog->categories()->sync($request->input('blog_category_id', []));

            return $blog;
        });

        return redirect()->route('blogs.index')->with('success', 'Blog created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        $statuses = \Config::get('custom')['statuses'];
        $languages = [
            ['code' => 'en', 'flag' => 'gb', 'name' => 'English'],
            ['code' => 'zh', 'flag' => 'cn', 'name' => '中文'],
        ];
        $categories = BlogCategory::with(['translations' => function ($q) {
            $q->where('locale', 'en');
        }])->orderBy('id')->get();

        $blog->load('translations');

        
        return view('admin.blogs.edit', [
            'blog' => $blog,
            'languages' => $languages,
            'statuses' => $statuses,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogRequest $request, Blog $blog)
    {
        $data = $request->validated();

        DB::beginTransaction();

        try {
            // Update main table
            $blog->update([
                'status' => (bool) $data['status'],
                'thumbnail' => $data['thumbnail'] ?? null,
                'published_at' => now(),
            ]);
          
            // Update translations
            foreach (['en', 'zh'] as $locale) {
                $translationData = [
                    'title' => $data["title_{$locale}"] ?? null,
                    'short_description' => $data["short_description_{$locale}"] ?? null,
                    'content' => $data["content_{$locale}"] ?? null,
                    'meta_title' => $data["meta_title_{$locale}"] ?? null,
                    'meta_description' => $data["meta_description_{$locale}"] ?? null,
                    'meta_keywords' => $data["meta_keywords_{$locale}"] ?? null,
                ];
                $blog->translations()->updateOrCreate(['locale' => $locale], $translationData);
            }

            // Update Category
            $blog->categories()->sync($request->input('blog_category_id', []));


            DB::commit();
            return redirect()->route('blogs.index')->with('success', 'Blog updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        if ($blog->thumbnail) {
            Storage::disk('public')->delete($blog->thumbnail);
        }

        $blog->delete();

        return response()->json(['message' => 'Blog deleted successfully.']);
    }
}
