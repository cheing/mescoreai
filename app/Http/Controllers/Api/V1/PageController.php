<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\PageTranslation;
use App\Http\Requests\StorePageRequest;
use App\Http\Requests\UpdatePageRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PageController extends Controller
{

        protected $languages = [
            ['code' => 'en', 'flag' => 'gb', 'name' => 'English'],
            ['code' => 'zh', 'flag' => 'cn', 'name' => '中文'],
        ];
        protected $statuses = [
            1 => 'Published',
            0 => 'Draft',
        ];

       

    private $limits = 15;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort = $request->input('sort', 'id');
        $direction = $request->input('direction', 'desc');
        

        $query = Page::with([
            'translations' => fn($q) => $q->where('locale', 'en'),
        ]);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($sort === 'title_en') {
            $query->leftJoin('page_translations as t_en', function ($join) {
                $join->on('pages.id', '=', 't_en.page_id')
                     ->where('t_en.locale', '=', 'en');
            })->orderBy('t_en.title', $direction)
              ->select('pages.*');
        } else {
            $query->orderBy($sort, $direction);
        }

        $pages = $query->paginate($this->limits);

        $statuses = \Config::get('custom')['statuses'];

        return view('admin.pages.index',[
            'pages' => $pages,
            'statuses' => $this->statuses,
        ]); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $languages = $this->languages;
        $statuses = $this->statuses;
        return view('admin.pages.create', compact('languages', 'statuses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePageRequest $request)
    {
        $data = $request->validated();

        $page = DB::transaction(function () use ($request, $data) {
            // Create main record
            $page = Page::create([
                'slug' => Str::slug($data['title_en']),
                'sort' => $data['sort'] ?? 0,
                'status' => (bool) $data['status'],
                'menu_position' => $data['menu_position'],
            ]);

            // Create translations
            $page->translations()->createMany([
                [
                    'locale' => 'en',
                    'title' => $data['title_en'],
                    'content' => $data['content_en'] ?? null,
                    'meta_title' => $data['meta_title_en'] ?? null,
                    'meta_description' => $data['meta_description_en'] ?? null,
                    'meta_keywords' => $data['meta_keywords_en'] ?? null,
                ],
                [
                    'locale' => 'zh',
                    'title' => $data['title_zh'] ?? null,
                    'content' => $data['content_zh'] ?? null,
                    'meta_title' => $data['meta_title_zh'] ?? null,
                    'meta_description' => $data['meta_description_zh'] ?? null,
                    'meta_keywords' => $data['meta_keywords_zh'] ?? null,
                ],
            ]);

            return $page;
        });

        return redirect()->route('pages.index')->with('success', 'Page created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        $languages = $this->languages;
        $statuses = $this->statuses;
        $page->load('translations');
        return view('admin.pages.edit', compact('page', 'languages', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePageRequest  $request
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePageRequest $request, Page $page)
    {
        $data = $request->validated();

        DB::beginTransaction();

        try {
            // Update main table
            $page->update([
                'slug' => $data['slug'],
                'sort' => $data['sort'] ?? 0,
                'status' => (bool) $data['status'],
                'menu_position' => $data['menu_position'],
            ]);
          
            // Update translations
            foreach (['en', 'zh'] as $locale) {
                $translationData = [
                    'title' => $data["title_{$locale}"] ?? null,
                    'content' => $data["content_{$locale}"] ?? null,
                    'meta_title' => $data["meta_title_{$locale}"] ?? null,
                    'meta_description' => $data["meta_description_{$locale}"] ?? null,
                    'meta_keywords' => $data["meta_keywords_{$locale}"] ?? null,
                ];
                $page->translations()->updateOrCreate(['locale' => $locale], $translationData);
            }

            DB::commit();
            return redirect()->route('pages.index')->with('success', 'Page updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        $page->delete();

        return response()->json(['message' => 'Page deleted successfully.']);
    }
}
