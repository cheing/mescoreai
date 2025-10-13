<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePromotionRequest;
use App\Http\Requests\UpdatePromotionRequest;
use App\Http\Resources\V1\PromotionResource;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PromotionController extends Controller
{
    private $limits = 15;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sort = $request->input('sort', 'id');
        $direction = $request->input('direction', 'desc');

        $query = Promotion::with(['translations' => function ($q) {
            $q->where('locale', 'en');
        }]);

        if ($sort === 'title_en') {
            $query->leftJoin('promotion_translations as t_en', function ($join) {
                $join->on('promotions.id', '=', 't_en.promotion_id')
                    ->where('t_en.locale', '=', 'en');
            })->orderBy('t_en.title', $direction)
            ->select('promotions.*');
        } else {
            $query->orderBy($sort, $direction);
        }

        $promotions = $query->paginate($this->limits);

        return view('admin.promotions.index', compact('promotions'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         $languages = [
           [
                'code' => 'en',
                'flag' => 'us',
                'name' => 'English',
            ],
            [
                'code' => 'zh',
                'flag' => 'cn',
                'name' => 'Chinese',
            ],
        ];
        $status = \Config::get('custom')['statuses'];

        return view('admin.promotions.create', ['languages' => $languages, 'statuses' => $status]); // 传递到视图
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePromotionRequest $request)
    {
        $data = $request->validated();

        $promotion = DB::transaction(function () use ($request, $data) {

            // Create main record
            $promotion = Promotion::create([
                'slug' => Str::slug($data['title_en']),
                'thumbnail' =>$data['thumbnail'] ?? null,
                'redirect_url' => $data['redirect_url'] ?? null,
                'sort' => $data['sort'] ?? 0,
                'status' => (bool) $data['status'],
            ]);

            // Create translation records
            $promotion->translations()->createMany([
                [
                    'locale' => 'en',
                    'title' => $data['title_en'],
                    'short_description' => $data['short_description_en'] ?? null,
                ],
                [
                    'locale' => 'zh',
                    'title' => $data['title_zh'] ?? null,
                    'short_description' => $data['short_description_zh'] ?? null,
                ],
            ]);

            return $promotion;
        });

        return new PromotionResource($promotion);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Promotion $promotion)
    {

        $languages = [
           [
                'code' => 'en',
                'flag' => 'us',
                'name' => 'English',
            ],
            [
                'code' => 'zh',
                'flag' => 'cn',
                'name' => 'Chinese',
            ],
        ];
        $status = \Config::get('custom')['statuses'];

        $promotion->load('translations');

         return view('admin.promotions.edit', ['promotion' => $promotion, 'languages' => $languages, 'statuses' => $status]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePromotionRequest $request, Promotion $promotion)
    {
        $data = $request->validated();

        $promotion = DB::transaction(function () use ($request, $promotion, $data) {
           
            $promotion->update([
                'redirect_url' => $data['redirect_url'] ?? null,
                'thumbnail' =>$data['thumbnail'] ?? null,
                'sort' => $data['sort'] ?? 0,
                'status' => (bool) $data['status'],
            ]);

            foreach (['en', 'zh'] as $locale) {
                $promotion->translations()->updateOrCreate(
                    ['locale' => $locale],
                    [
                        'title' => $data["title_{$locale}"] ?? null,
                        'short_description' => $data["short_description_{$locale}"] ?? null,
                    ]
                );
            }

            return $promotion;
        });

        return new PromotionResource($promotion);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Promotion $promotion)
    {
        if ($promotion->thumbnail) {
            Storage::disk('public')->delete($promotion->thumbnail);
        }

        $promotion->delete();

        return response()->json(['message' => 'Promotion deleted successfully']);
    }
}
