<?php

namespace App\Models;

use App\Enums\SourceEnum;
use App\Enums\TypeItineraryEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Itinerary extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'itineraries';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'itinerary_picture',
        'user_id',
        'length',
        'positive_drop',
        'negative_drop',
        'estimated_time',
        'difficulty',
        'source',
        'type', // 'type' is missing from the original code snippet
        'image_id',
        'pdf_url',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */

    protected $casts = [
        'length' => 'float',
        'positive_drop' => 'float',
        'negative_drop' => 'float',
        'estimated_time' => 'float',
        'difficulty' => 'string',
        'user_id' => 'integer',
        'image_id' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function image()
    {
        return $this->belongsTo(Image::class);
    }

    public function steps()
    {
        return $this->hasMany(Step::class);
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
    public function tagCategorie()
    {
        return $this->belongsToMany(TagCategorie::class);
    }

    public function tagAccessibility()
    {
        return $this->belongsToMany(TagAccessibility::class);
    }

    public function getFormattedUpdatedAtAttribute()
    {
        return $this->updated_at->toDateString();
    }
}
