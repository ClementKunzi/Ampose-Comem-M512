<?php

namespace App\Models;

use App\Enums\TypeAlertEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'alert';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'description',
        'reporting_time',
        'itinerary_id',
        'user_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'itinerary_id' => 'integer',
        'user_id' => 'integer',
        'reporting_time' => 'datetime',
        'type' => TypeAlertEnum::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function itinerary()
    {
        return $this->belongsTo(Itinerary::class);
    }
}
