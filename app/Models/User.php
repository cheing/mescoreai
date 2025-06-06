<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['username', 'name', 'email', 'email_verified_at', 'password', 'remember_token', 'status', 'role', 'phone', 'subscribe', 'me88username'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'subscribe' => 'boolean',
    ];

    public function activeSubscription()
    {
        return $this->hasOne(Subscription::class)
                    ->where('start_date', '<=', now())
                    ->where(function($query) {
                        $query->where('end_date', '>=', now())
                              ->orWhereNull('end_date');  // Assuming null end_date means unlimited
                    });
    }
    
}
