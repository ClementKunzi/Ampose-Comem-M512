<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\Taxonomy;
use App\Models\TagAccessibility;
use App\Models\TagCategorie;
use Illuminate\Support\Facades\File;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Read the JSON file
        $json = File::get(database_path('seeders/data/taxonomy.json'));

        // Decode the JSON data
        $data = json_decode($json);

        // Insert or update each tag in the database
        foreach ($data as $tag) {
            $taxonomy = Taxonomy::updateOrCreate(
                ['name' => $tag->name],
                [
                    'description' => $tag->description,
                    'icon' => $tag->icon,
                ]
            );

            if ($tag->tag == 'accessibility') {
                TagAccessibility::updateOrCreate(['taxonomy_id' => $taxonomy->id]);
            } elseif ($tag->tag == 'categorie') {
                TagCategorie::updateOrCreate(['taxonomy_id' => $taxonomy->id]);
            }
        }
    }
}
