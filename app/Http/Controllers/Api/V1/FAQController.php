<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFAQRequest;
use App\Http\Requests\UpdateFAQRequest;
use App\Http\Resources\V1\FAQResource;
use App\Models\FAQ;
use Illuminate\Http\Request;

class FAQController extends Controller
{
    private $limits = 15;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort = $request->input('sort', 'sort');
        $direction = $request->input('direction', 'asc');

        $faqs = FAQ::orderBy($sort, $direction)
        ->paginate($this->limits);

        return view('admin.faqs.index', [
            'faqs' => $faqs,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.faqs.create'); // 传递到视图
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFAQRequest $request)
    {
        $data = $request->validated();

        return new FAQResource(FAQ::create($data));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(FAQ $faq)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(FAQ $faq) // Use $faq here instead of $fAQ
    {
        return view('admin.faqs.edit', ['faq' => $faq]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFAQRequest $request, FAQ $faq)
    {
        $data = $request->validated();

        $faq->update($data);

        return new FAQResource($faq);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(FAQ $faq)
    {
        $faq->delete();

        return response()->json(['message' => 'FAQ deleted successfully']);
    }
}
