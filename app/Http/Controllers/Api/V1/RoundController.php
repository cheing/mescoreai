<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoundRequest;
use App\Http\Requests\UpdateRoundRequest;
use App\Http\Resources\V1\RoundResource;
use App\Models\Point;
use App\Models\Prediction;
use App\Models\Round;
use Illuminate\Http\Request;

class RoundController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rounds = Round::all();

        return view('admin.rounds.index', [
            'rounds' => $rounds,
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
    public function store(StoreRoundRequest $request)
    {
        $data = $request->validated();

        return new RoundResource(Round::create($data));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Round $round)
    {
        return new RoundResource($round);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Round $round)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoundRequest $request, Round $round)
    {
        $validatedData = $request->validated();

        $round->update($validatedData);

        return new RoundResource($round);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Round $round)
    {
        $round->delete();

        return response()->json(['message' => 'Round deleted successfully']);
    }

    public function setWinner(Round $round, Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'winner_id' => 'required|exists:teams,id',
        ]);

        // Update the winner_id for the round
        $round->update(['winner_id' => $validatedData['winner_id']]);

        // Update the points for users who predicted correctly
        // Assuming you have a points system in place
        $correctPredictions = Prediction::where('round_id', $round->id)
                                        ->where('predicted_winner_id', $validatedData['winner_id'])
                                        ->get();

        // remove existing point
        Point::where('round_id', $round->id)->delete();

        foreach ($correctPredictions as $prediction) {
            // Add points to the user. Adjust the points logic as per your application's requirement
            Point::create([
                'tournament_id' => $round->match->tournament->id,
                'round_id' => $round->id,
                'user_id' => $prediction->user_id,
                'points' => $round->points,
            ]);
        }

        // Return a success message
        return response()->json(['message' => 'Winner set successfully and points awarded.']);
    }
}
