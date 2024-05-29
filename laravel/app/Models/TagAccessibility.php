<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagAccessibility extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tag_accessibility';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'taxonomy_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'taxonomy_id' => 'integer',
    ];

    public function taxonomy()
    {
        return $this->belongsTo(Taxonomy::class);
    }
    public function itineraries()
    {
        return $this->belongsToMany(Itinerary::class);
    }
}
