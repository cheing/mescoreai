<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Http\Resources\V1\TeamResource;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeamController extends Controller
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

        // 示例：每页显示10个团队，按照名称排序
        $teams = Team::orderby('name')
        ->paginate($this->limits);
        // $teams = Team::all();

        return view('admin.teams.index', [
            'teams' => $teams,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.teams.create'); // 传递到视图
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTeamRequest $request)
    {
        $data = $request->validated();

        return new TeamResource(Team::create($data));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Team $team)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Team $team)
    {
        return view('admin.teams.edit', ['team' => $team]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTeamRequest $request, Team $team)
    {
        $validatedData = $request->validated();

        $team->update($validatedData);

        return new TeamResource($team);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team $team)
    {
        if (!empty($team->image)) {
            Storage::delete('public/'.$team->image);
        }
        $team->delete();

        return response()->json(['message' => 'Team deleted successfully']);
    }
}
