<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePackageRequest;
use App\Http\Requests\UpdatePackageRequest;
use App\Http\Resources\V1\PackageResource;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
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

        $packages = Package::orderBy($sort, $direction)
        ->paginate($this->limits);

        return view('admin.packages.index', [
            'packages' => $packages,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
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

        return view('admin.packages.create', ['languages' => $languages, 'statuses' => $status]); // 传递到视图
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StorePackageRequest $request)
    {
        $data = $request->validated();
        $package = new Package();
        $package->name = $data['name'];
        $package->status = $data['status'];
        $package->sort = $data['sort'];
        $package->duration = $data['duration'];

        // Combine multilingual fields into one JSON column
        $package->descriptions = [
            'display_name' => [
                'en' => $data['display_name']['en'],
                'zh' => $data['display_name']['zh'],
            ],
            'short_description' => [
                'en' => $data['short_description']['en'],
                'zh' => $data['short_description']['zh'],
            ],
            'description' => [
                'en' => $data['description']['en'],
                'zh' => $data['description']['zh'],
            ],
        ];

        $package->save();

        return new PackageResource($package);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Package $package)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Package $package)
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

        // Ensure package descriptions are decoded if they're stored as JSON
        // $package->descriptions = json_decode($package->descriptions, true) ?? [];
        $status = \Config::get('custom')['statuses'];

        return view('admin.packages.edit', ['package' => $package, 'languages' => $languages, 'statuses' => $status]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePackageRequest $request, Package $package)
    {
        $data = $request->validated();
        $package->name = $data['name'];
        $package->status = $data['status'];
        $package->sort = $data['sort'];
        $package->duration = $data['duration'];

        // Combine multilingual fields into one JSON column
        $package->descriptions = [
            'display_name' => [
                'en' => $data['display_name']['en'],
                'zh' => $data['display_name']['zh'],
            ],
            'short_description' => [
                'en' => $data['short_description']['en'],
                'zh' => $data['short_description']['zh'],
            ],
            'description' => [
                'en' => $data['description']['en'],
                'zh' => $data['description']['zh'],
            ],
        ];

        $package->save();

        return new PackageResource($package);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Package $package)
    {
        $package->delete();

        return response()->json(['message' => 'Package deleted successfully']);
    }
}
