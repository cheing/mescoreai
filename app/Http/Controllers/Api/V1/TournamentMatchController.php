<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTournamentMatchRequest;
use App\Http\Requests\UpdateTournamentMatchRequest;
use App\Http\Resources\V1\MatchResource;
use App\Models\TournamentMatch;

class TournamentMatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $matches = TournamentMatch::all();

        return view('admin.tournaments.index', [
            'matches' => $matches,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $matchstatus = \Config::get('custom')['match_statuses'];

        return view('admin.tournaments.create', ['match_statuses' => $matchstatus]); // 传递到视图
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTournamentMatchRequest $request)
    {
        $data = $request->validated();

        return new MatchResource(TournamentMatch::create($data));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(TournamentMatch $tournamentMatch)
    {
        return new MatchResource($tournamentMatch);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(TournamentMatch $tournamentMatch)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTournamentMatchRequest $request, TournamentMatch $match)
    {
        $validatedData = $request->validated();

        $match->update($validatedData);

        return new MatchResource($match);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(TournamentMatch $match)
    {
        $match->delete();

        return response()->json(['message' => 'Match deleted successfully']);
    }
}
