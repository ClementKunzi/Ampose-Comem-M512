<?php

namespace App\Models;

use App\Enums\ColorCategorieEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagCategorie extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tag_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'color',
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

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'color' => '', // replace 'default_color' with your default color
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
