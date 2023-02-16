<?php

namespace App\Http\Requests\Game;

use Closure;
use App\Models\Game;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $request = $this->request->all();

        return [
            'games' => 'required|array',
            'games.*.home_id' => [
                'required',
                'different:games.*.away_id',
                'exists:teams,id',
                function (string $attribute, mixed $value, Closure $fail) use ($request) {
                    $awayId = $request['games'][explode('.', $attribute)[1]]['away_id'];
                    if (Game::where('home_id', $value)->where('away_id', $awayId)->first()) {
                        $fail('Pertandingan sudah dimainkan');
                    }
                },
                function (string $attribute, mixed $value, Closure $fail) use ($request) {
                    $index = explode('.', $attribute)[1];
                    $awayId = $request['games'][$index]['away_id'];
                    foreach ($request['games'] as $key => $game) {
                        if ($value == $game['home_id'] && $awayId == $game['away_id'] && $index != $key) {
                            $fail('Tidak boleh ada pertandingan yang sama');
                        }
                    }
                },
            ],
            'games.*.away_id' => 'required|exists:teams,id',
            'games.*.home_score' => 'required|integer|min:0',
            'games.*.away_score' => 'required|integer|min:0',
            'games.*.date' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'games.*.home_id.required' => 'Home team required',
            'games.*.home_id.different' => 'Home team must be different with away team',
            'games.*.home_id.exists' => 'Home team must be exists in teams table',
            'games.*.away_id.required' => 'Away team required',
            'games.*.away_id.different' => 'Away team must be different with home team',
            'games.*.away_id.exists' => 'Away team must be exists in teams table',
            'games.*.home_score.required' => 'Home team score required',
            'games.*.home_score.integer' => 'Home team score must be number',
            'games.*.home_score.min' => 'Home team score minimal 8',
            'games.*.away_score.required' => 'Away team score required',
            'games.*.away_score.integer' => 'Away team score must be number',
            'games.*.away_score.min' => 'Away team score minimal 8',
            'games.*.date.required' => 'Match date required',
        ];
    }
}
