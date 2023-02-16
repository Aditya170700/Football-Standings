<?php

namespace App\Http\Controllers;

use App\Http\Requests\Game\StoreRequest;
use App\Models\Game;
use App\Models\Team;
use App\Models\Standing;
use Illuminate\Support\Facades\DB;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = Game::with('home_team', 'away_team')
            ->orderBy('date')
            ->paginate(10);

        return view('game.index', [
            'results' => $results,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $home = Team::orderBy('name')->get();

        return view('game.create', [
            'home_teams' => $home,
            'away_teams' => $home,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        try {
            DB::beginTransaction();
            Game::insert($request->games);

            foreach ($request->games as $game) {
                $standingHt = Standing::where('team_id', $game['home_id'])->firstOrFail();
                $standingAt = Standing::where('team_id', $game['away_id'])->firstOrFail();
                $updateHt = [
                    'ma' => $standingHt->ma + 1,
                    'me' => $standingHt->me,
                    's' => $standingHt->s,
                    'k' => $standingHt->k,
                    'gm' => $standingHt->gm,
                    'gk' => $standingHt->gk,
                    'sg' => $standingHt->sg,
                    'point' => $standingHt->point,
                ];
                $updateAt = [
                    'ma' => $standingAt->ma + 1,
                    'me' => $standingAt->me,
                    's' => $standingAt->s,
                    'k' => $standingAt->k,
                    'gm' => $standingAt->gm,
                    'gk' => $standingAt->gk,
                    'sg' => $standingAt->sg,
                    'point' => $standingAt->point,
                ];

                if ($game['home_score'] > $game['away_score']) {
                    $updateHt['me'] += 1;
                    $updateHt['gm'] += $game['home_score'];
                    $updateHt['gk'] += $game['away_score'];
                    $updateHt['sg'] += $game['home_score'] - $game['away_score'];
                    $updateHt['point'] += 3;

                    $updateAt['k'] += 1;
                    $updateAt['gm'] += $game['away_score'];
                    $updateAt['gk'] += $game['home_score'];
                    $updateAt['sg'] += $game['away_score'] - $game['home_score'];
                } else if ($game['home_score'] < $game['away_score']) {
                    $updateAt['me'] += 1;
                    $updateAt['gm'] += $game['away_score'];
                    $updateAt['gk'] += $game['home_score'];
                    $updateAt['sg'] += $game['away_score'] - $game['home_score'];
                    $updateAt['point'] += 3;

                    $updateHt['k'] += 1;
                    $updateHt['gm'] += $game['home_score'];
                    $updateHt['gk'] += $game['away_score'];
                    $updateHt['sg'] += $game['home_score'] - $game['away_score'];
                } else {
                    $updateHt['s'] += 1;
                    $updateHt['gm'] += $game['home_score'];
                    $updateHt['gk'] += $game['away_score'];
                    $updateHt['sg'] += $game['home_score'] - $game['away_score'];
                    $updateHt['point'] += 1;

                    $updateAt['s'] += 1;
                    $updateAt['gm'] += $game['away_score'];
                    $updateAt['gk'] += $game['home_score'];
                    $updateAt['sg'] += $game['away_score'] - $game['home_score'];
                    $updateAt['point'] += 1;
                }

                $standingHt->update($updateHt);
                $standingAt->update($updateAt);
            }

            DB::commit();
            return redirect()->route('games.index')->with('success', 'Berhasil input data');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
