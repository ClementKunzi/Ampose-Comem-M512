<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'image';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'url',
        'alt_attr',
    ];




    public function itineraries()
    {
        return $this->hasMany(Itinerary::class);
    }

    public function steps()
    {
        return $this->belongsToMany(Step::class);
    }
}
