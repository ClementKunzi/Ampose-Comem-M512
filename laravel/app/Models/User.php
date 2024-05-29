<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable  implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

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

    public function tokens()
    {
        return $this->morphMany(\Laravel\Sanctum\PersonalAccessToken::class, 'tokenable');
    }

    public function createToken(string $name)
    {
        $token = hash('sha256', $plainTextToken = Str::random(80));

        $accessToken = $this->tokens()->create([
            'name' => $name,
            'token' => $token,
        ]);

        return new \Laravel\Sanctum\NewAccessToken(
            $accessToken,
            $accessToken->getKey() . '|' . $plainTextToken
        );
    }

    public function hasVerifiedEmail()
    {
        return $this->email_verified_at !== null;
    }

    public function markEmailAsVerified()
    {
        $this->email_verified_at = $this->freshTimestamp();
        $this->email_verification = true;
        $this->save();
    }

    public function sendEmailVerificationNotification()
    {
    }

    public function getEmailForVerification()
    {
        return $this->email;
    }
}
