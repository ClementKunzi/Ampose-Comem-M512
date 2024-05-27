<?php

namespace App\Models;

use App\Enums\NameTaxonomyEnum;
use App\Enums\DescriptionTaxonomyEnum;
use Hamcrest\Description;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taxonomy extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'taxonomy';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'icon',
    ];




    public function tagCategories()
    {
        return $this->hasMany(TagCategorie::class);
    }

    public function tagAccessibilities()
    {
        return $this->hasMany(TagAccessibility::class);
    }
}
