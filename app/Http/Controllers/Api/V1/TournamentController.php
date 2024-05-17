<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTournamentRequest;
use App\Http\Requests\UpdateTournamentRequest;
use App\Http\Resources\V1\TournamentResource;
use App\Models\Team;
use App\Models\Tournament;

class TournamentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tournaments = Tournament::all();

        return view('admin.tournaments.index', [
            'tournaments' => $tournaments,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $status = \Config::get('custom')['statuses'];

        return view('admin.tournaments.create', ['statuses' => $status]); // 传递到视图

        // return view('admin.tournaments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTournamentRequest $request)
    {
        $data = $request->validated();

        return new TournamentResource(Tournament::create($data));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Tournament $tournament)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Tournament $tournament)
    {
        // 预加载赛事关联的所有比赛
        $tournament->load('matches');

        $tournamentResource = new TournamentResource($tournament);
        $status = \Config::get('custom')['statuses'];
        $teams = Team::all(); // 获取所有国家

        return view('admin.tournaments.edit', ['tournament' => $tournamentResource, 'statuses' => $status,  'teams' => $teams]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTournamentRequest $request, Tournament $tournament)
    {
        $validatedData = $request->validated();

        $tournament->update($validatedData);

        return new TournamentResource($tournament);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tournament $tournament)
    {
        $tournament->delete();

        return response()->json(['message' => 'Tournament deleted successfully']);
    }
}
