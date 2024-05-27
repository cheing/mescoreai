<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'title_zh', 'start_date', 'end_date', 'status', 'sort'];

    public function matches()
    {
        return $this->hasMany(TournamentMatch::class)->orderBy('start_time', 'asc');
    }
}
