<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TournamentMatch extends Model
{
    use HasFactory;

    protected $table = 'matches'; // 指定数据库表名
    protected $dates = ['start_time'];

    protected $fillable = ['tournament_id', 'start_time', 'status', 'team_a_id', 'team_b_id', 'first_odd', 'x_odd', 'second_odd', 'tip', 'tip_odd', 'handicap', 'handicap_odd', 'o_u', 'o_u_odd', 'correct_score', 'correct_score_odd', 'best_tip', 'best_tip_odd'];

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    public function teamA()
    {
        return $this->belongsTo(Team::class, 'team_a_id');
    }

    public function teamB()
    {
        return $this->belongsTo(Team::class, 'team_b_id');
    }
}
