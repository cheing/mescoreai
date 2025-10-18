<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;    
use App\Models\BlogCategoryTranslation;   
use App\Http\Requests\StoreBlogCategoryRequest;
use App\Http\Requests\UpdateBlogCategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogCategoryController extends Controller
{
    private $limits = 15;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sort = $request->input('sort', 'id');
        $direction = $request->input('direction', 'desc');

        $query = BlogCategory::with(['translations' => function ($q) {
            $q->where('locale', 'en');
        }]);

        if ($sort === 'name_en') {
            $query->leftJoin('blog_category_translations as t_en', function ($join) {
                $join->on('blog_categories.id', '=', 't_en.blog_category_id')
                     ->where('t_en.locale', '=', 'en');
            })->orderBy('t_en.name', $direction)
              ->select('blog_categories.*');
        } else {
            $query->orderBy($sort, $direction);
        }

        $categories = $query->paginate($this->limits);


        return view('admin.blog-categories.index', compact('categories'));
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
        $blogCategory = BlogCategory::with(['translations' => function ($q) {
            $q->where('locale', 'en');
        }])->orderBy('id')->get();

        return view('admin.blog-categories.create', [
            'languages' => $languages,
            'statuses' => $statuses,
            'category' => $blogCategory,
        ]);
    }

    /**
     * Store a newly created resource.
     */
    public function store(StoreBlogCategoryRequest $request)
    {
        $data = $request->validated();

        $blogCategory = DB::transaction(function () use ($request, $data) {
            // Create main record
            $blogCategory = BlogCategory::create([
                'slug' => Str::slug($data['name_en']),
                'sort' => $data['sort'] ?? 0,
                'status' => (bool) $data['status'],
            ]);

            // Create translations
            $blogCategory->translations()->createMany([
                [
                    'locale' => 'en',
                    'name' => $data['name_en'] ?? null,
                    'description' => $data['description_en'] ?? null,
                    'meta_title' => $data['meta_title_en'] ?? null,
                    'meta_description' => $data['meta_description_en'] ?? null,
                    'meta_keywords' => $data['meta_keywords_en'] ?? null,
                ],
                [
                    'locale' => 'zh',
                    'name' => $data['name_zh'] ?? null,
                    'description' => $data['description_zh'] ?? null,
                    'meta_title' => $data['meta_title_zh'] ?? null,
                    'meta_description' => $data['meta_description_zh'] ?? null,
                    'meta_keywords' => $data['meta_keywords_zh'] ?? null,
                ],
            ]);
            
            return $blogCategory;
        });

        return redirect()->route('blogs.index')->with('success', 'Blog created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlogCategory $blogCategory)
    {
        $statuses = \Config::get('custom')['statuses'];
        $languages = [
            ['code' => 'en', 'flag' => 'gb', 'name' => 'English'],
            ['code' => 'zh', 'flag' => 'cn', 'name' => '中文'],
        ];


        $blogCategory->load('translations');
        
        return view('admin.blog-categories.edit', [
            'category' => $blogCategory,
            'languages' => $languages,
            'statuses' => $statuses
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogCategoryRequest $request, BlogCategory $blogCategory)
    {
        $data = $request->validated();

        DB::beginTransaction();

        try {
            // Update main table
            $blogCategory->update([
                'status' => (bool) $data['status'],
                'sort' => $data['sort'] ?? 0,
            ]);
          
            // Update translations
            foreach (['en', 'zh'] as $locale) {
                $translationData = [
                    'name' => $data["name_{$locale}"] ?? null,
                    'description' => $data["description_{$locale}"] ?? null,
                    'meta_title' => $data["meta_title_{$locale}"] ?? null,
                    'meta_description' => $data["meta_description_{$locale}"] ?? null,
                    'meta_keywords' => $data["meta_keywords_{$locale}"] ?? null,
                ];
                $blogCategory->translations()->updateOrCreate(['locale' => $locale], $translationData);
            }

            DB::commit();
            return redirect()->route('blog-categories.index')->with('success', 'Category updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogCategory $blogCategory)
    {
        $blogCategory->delete();

        return response()->json(['message' => 'Category deleted successfully.']);
    }
}
