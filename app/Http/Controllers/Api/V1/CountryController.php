<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCountryRequest;
use App\Http\Requests\UpdateCountryRequest;
use App\Http\Resources\V1\CountryResource;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    private $limits = 15;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort = $request->input('sort', 'name');
        $direction = $request->input('direction', 'asc');

        $countries = Country::orderBy($sort, $direction)
        ->paginate($this->limits);

        return view('admin.countries.index', [
            'countries' => $countries,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.countries.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCountryRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('flag')) {
            $file = $request->file('flag');

            // 保存文件到 storage/app/public/flags 目录下，并生成一个唯一的文件名
            $data['flag'] = $file->store('flags', 'public');

            // 其他逻辑，例如保存文件路径到数据库等

            // return response()->json(['message' => 'File uploaded successfully', 'path' => $filePath]);
        }

        return new CountryResource(Country::create($data));

        // return $this->JsonOk();
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Country $country)
    {
        // echo '<pre>1111';
        // print_r($country);
        // echo '</pre>';

        // return view('admin.countries.edit', compact(CountryResource($country)));

        // return view('admin.countries.form');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Country $country)
    {
        $countryResource = new CountryResource($country);

        return view('admin.countries.edit', ['country' => $countryResource]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCountryRequest $request, Country $country)
    {
        $validatedData = $request->validated();

        // if ($request->hasFile('flag')) {
        //     $filePath = $request->file('flag')->store('flags', 'public');
        //     $validatedData['flag'] = $filePath;
        // }
        $country->update($validatedData);

        return new CountryResource($country);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Country $country)
    {
        $country->delete();

        return response()->json(['message' => 'Country deleted successfully']);
    }
}
