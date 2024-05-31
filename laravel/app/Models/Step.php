<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'steps';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'adress',
        'schedule',
        'latitude',
        'longitude',
        'order',
        'external_link',
        'itinerary_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'ordre' => 'integer',
        'itinerary_id' => 'integer',
    ];

    public function itinerary()
    {
        return $this->belongsTo(Itinerary::class);
    }

    public function images()
    {
        return $this->belongsToMany(Image::class);
    }

    public function getFormattedUpdatedAtAttribute()
    {
        return $this->updated_at->toDateString();
    }
}
