<?php

namespace App\Http\Controllers;

use App\Http\Resources\GameResource;
use App\Models\Game;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $games = Game::where("created_user_id", "=", 7)->with('board');

        $gameType = $request->query("gameType");
        if (!empty($gameType) && in_array($gameType, ["3x4", "4x4", "6x6"])) {
            $games->whereHas('board', function ($query) use ($gameType) {
                $query->where('board_cols', '=', explode("x", $gameType)[0]);
            });
        }

        $date = $request->query("date");
        if (!empty($date)) {
            $games->whereDate("began_at", "=", Carbon::parse($date)->format('Y-m-d'));
        }

        $by = $request->query("by");
        if (!empty($by) && in_array($by, ["gameType", "time", "turns", "date"])) {

            $convert = [
                "date" => 'began_at',
                "turns" => 'custom->user1',
                "time" => 'total_time',
                "gameType" => 'board_id',
            ];

            $by = $convert[$by];

            $games->orderBy($by, $request->query("order") == "desc" ? "desc" : "asc");
        }

        return GameResource::collection($games->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $game = Game::create($request->all());
        return new GameResource($game);
    }

    /**
     * Display the specified resource.
     */
    public function show(Game $game)
    {
        return new GameResource($game);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Game $game)
    {
        Game::destroy($game->id);
        return new GameResource($game);
    }

    public function global_history(Request $request){
        $games = Game::with('board')->whereNotNull("total_time");

        $gameType = $request->query("gameType");
        if (!empty($gameType) && in_array($gameType, ["3x4", "4x4", "6x6"])) {
            $games->whereHas('board', function ($query) use ($gameType) {
                $query->where('board_cols', '=', explode("x", $gameType)[0]);
            });
        }

        
        $static = $request->query("static");
        if($static != "time"){
            $games->orderByRaw("CONVERT(JSON_EXTRACT(custom, '$.user1'), SIGNED) asc");
        }else{
            $games->orderBy("total_time",  "asc");
        }


        return GameResource::collection(resource: $games->take(10)->get());
    }
}
