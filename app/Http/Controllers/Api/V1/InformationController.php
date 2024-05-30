<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInformationRequest;
use App\Http\Requests\UpdateInformationRequest;
use App\Http\Resources\V1\InformationResource;
use App\Models\Information;
use Illuminate\Http\Request;

class InformationController extends Controller
{
    private $limits = 15;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort = $request->input('sort', 'key');
        $direction = $request->input('direction', 'asc');

        $informations = Information::orderBy($sort, $direction)
        ->paginate($this->limits);

        return view('admin.informations.index', [
            'informations' => $informations,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.informations.create'); // 传递到视图
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInformationRequest $request)
    {
        $data = $request->validated();

        return new InformationResource(Information::create($data));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Information $information)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Information $information) // Use $information here instead of $fAQ
    {
        return view('admin.informations.edit', ['information' => $information]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInformationRequest $request, Information $information)
    {
        $data = $request->validated();

        $information->update($data);

        return new InformationResource($information);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Information $information)
    {
        $information->delete();

        return response()->json(['message' => 'Information deleted successfully']);
    }
}
