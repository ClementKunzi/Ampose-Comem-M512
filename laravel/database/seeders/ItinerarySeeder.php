<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Itinerary;
use App\Models\Step;
use App\Models\Image;
use App\Models\TagAccessibility;
use App\Models\TagCategorie;
use App\Models\Taxonomy;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ItinerarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get(database_path('seeders/data/fake-data.json'));

        // Decode the JSON data
        $data = json_decode($json, true);

        // Get the ID of the user 'cantonVaud'
        $cantonVaudId = User::where('username', 'cantonVaud')->first()->id;

        // Get the IDs of all other users
        $otherUserIds = User::where('username', '!=', 'cantonVaud')->pluck('id')->toArray();

        foreach ($data as $item) {
            // Get image content from URL
            $imageContent = file_get_contents(base_path('database/seeders/data' . $item['image']['url']));

            $imageExtension = pathinfo($item['image']['url'], PATHINFO_EXTENSION);
            $imageName = time() . '_' . uniqid() . '.' . $imageExtension;

            // Define path to save image
            $imagePath = 'public/images/' . $imageName;

            // Save image to the defined path
            Storage::put($imagePath, $imageContent);

            // Créer une image pour l'itinéraire
            $image = Image::create([
                'url' => $imageName,
                'alt_attr' => $item['image']['alt_attr'],
            ]);
            $itinerary = Itinerary::create([
                'name' => $item['name'],
                'description' => $item['description'],
                'type' => $item['type'],
                'length' => $item['length'],
                'positive_drop' => $item['positive_drop'],
                'negative_drop' => $item['negative_drop'],
                'estimated_time' => $item['estimated_time'],
                'difficulty' => $item['difficulty'],
                'pdf_url' => 'https://www.google.com',
                'source' => $item['source'],
                'user_id' => $item['source'] === 'officiel' ? $cantonVaudId : $otherUserIds[array_rand($otherUserIds)],
                'image_id' => $image->id,
            ]);

            if (isset($item['category'])) {
                $categoryName = $item['category'];
                $taxonomy = Taxonomy::where('name', $categoryName)->first();
                if ($taxonomy) {
                    $tagCategorie = TagCategorie::where('taxonomy_id', $taxonomy->id)->first();
                    if ($tagCategorie) {
                        $itinerary->tagCategorie()->attach($tagCategorie->id);
                    }
                }
            }

            if (isset($item['accessibility'])) {
                $accessibilityName = $item['accessibility'];
                $taxonomy = Taxonomy::where('name', $accessibilityName)->first();
                if ($taxonomy) {
                    $tagAccessibility = TagAccessibility::where('taxonomy_id', $taxonomy->id)->first();
                    if ($tagAccessibility) {
                        $itinerary->tagAccessibility()->attach($tagAccessibility->id);
                    }
                }
            }





            foreach ($item['steps'] as $stepData) {

                $stepImageContent = file_get_contents(base_path('database/seeders/data' . $stepData['stepImage']));

                $stepImageExtension = pathinfo($stepData['stepImage'], PATHINFO_EXTENSION);
                $stepImageName = time() . '_' . uniqid() . '.' . $stepImageExtension;
                // Define path to save image
                $stepImagePath = 'public/images/' . $stepImageName;

                // Save image to the defined path
                Storage::put($stepImagePath, $stepImageContent);

                // Créer une image pour l'étape
                $stepImage = Image::create([
                    'url' => $stepImageName,
                    'alt_attr' => $stepData['image_description'],
                ]);

                $step = Step::create([
                    'itinerary_id' => $itinerary->id,
                    'name' => $stepData['name'],
                    'description' => $stepData['description'],
                    'adress' => $stepData['address'],
                    'latitude' => $stepData['latitude'],
                    'longitude' => $stepData['longitude'],
                    'order' => $stepData['order'],
                    'external_link' => $stepData['external_link'],
                ]);
                $step->images()->attach($stepImage->id);
            }
        }
    }
}
