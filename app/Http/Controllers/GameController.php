<?php

namespace App\Http\Controllers;

use Closure;
use App\Models\Game;
use App\Models\Team;
use App\Models\Standing;
use Illuminate\Http\Request;
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
    public function store(Request $request)
    {
        $request->validate([
            'games' => 'required|array',
            'games.*.home_id' => [
                'required',
                'different:games.*.away_id',
                'exists:teams,id',
                function (string $attribute, mixed $value, Closure $fail) use ($request) {
                    $awayId = $request->games[explode('.', $attribute)[1]]['away_id'];
                    if (Game::where('home_id', $value)->where('away_id', $awayId)->first()) {
                        $fail('Tidak boleh ada pertandingan yang sama');
                    }
                },
            ],
            'games.*.away_id' => 'required|exists:teams,id',
            'games.*.home_score' => 'required|integer|min:0',
            'games.*.away_score' => 'required|integer|min:0',
            'games.*.date' => 'required',
        ], [
            'games.*.home_id.required' => 'Home team required',
            'games.*.home_id.different' => 'Home team must be different with away team',
            'games.*.home_id.exists' => 'Home team must be exists in teams table',
            'games.*.away_id.required' => 'Away team required',
            'games.*.away_id.different' => 'Away team must be different with home team',
            'games.*.away_id.exists' => 'Away team must be exists in teams table',
            'games.*.home_score.required' => 'Home tean score required',
            'games.*.home_score.integer' => 'Home team score must be number',
            'games.*.home_score.min' => 'Home team score minimal 8',
            'games.*.away_score.required' => 'Away tean score required',
            'games.*.away_score.integer' => 'Away team score must be number',
            'games.*.away_score.min' => 'Away team score minimal 8',
            'games.*.date.required' => 'Match date required',
        ]);

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
