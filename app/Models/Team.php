<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function home_games()
    {
        return $this->hasMany(Game::class, 'home_id', 'id');
    }

    public function away_games()
    {
        return $this->hasMany(Game::class, 'away_id', 'id');
    }

    public function standing()
    {
        return $this->hasOne(Standing::class, 'team_id', 'id');
    }
}
