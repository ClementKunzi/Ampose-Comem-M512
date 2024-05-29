<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;


class User extends Model
{
    use HasApiTokens;
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'last_name',
        'first_name',
        'email',
        'password',
        'email_verification',
        'email_verified_at',
        'last_login',
        'number_path_added',
        'profile_picture',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'email_verification' => 'boolean',
    ];

    public function badges()
    {
        return $this->belongsToMany(Badge::class);
    }

    public function itineraries()
    {
        return $this->hasMany(Itinerary::class);
    }

    public function alerts()
    {
        return $this->hasMany(Alert::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
}
