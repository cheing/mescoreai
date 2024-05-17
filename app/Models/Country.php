<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'name_zh', 'code'];

    public function teams()
    {
        return $this->hasMany(Team::class);
    }
}
