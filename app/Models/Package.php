<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = ['sort', 'name', 'status', 'duration', 'descriptions'];

    protected $casts = [
        'descriptions' => 'array',
    ];
}
