<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\Taxonomy;
use App\Models\TagAccessibility;
use App\Models\TagCategorie;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

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
            $iconPath = base_path('database/seeders/data/' . $tag->icon);
            $iconContent = file_get_contents($iconPath);
            $imageExtension = pathinfo($tag->icon, PATHINFO_EXTENSION); // Correction ici
            $imageName = time() . '_' . uniqid() . '.' . $imageExtension;
            $path = 'public/icons/' . $imageName; // Chemin corrigé

            Storage::put($path, $iconContent);
            $taxonomy = Taxonomy::updateOrCreate(
                ['name' => $tag->name],
                [
                    'description' => $tag->description,
                    'icon' => $imageName,
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
