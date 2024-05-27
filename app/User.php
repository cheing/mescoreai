<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email',  'password', 'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function activeSubscription()
    {
        return $this->hasOne(\App\Models\Subscription::class)
                    ->where('start_date', '<=', now())
                    ->where(function ($query) {
                        $query->where('end_date', '>=', now())
                              ->orWhereNull('end_date');  // Assuming null end_date means unlimited
                    })->first();  // Use `first` to get the actual subscription or null
    }
}
