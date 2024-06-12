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
use TCPDF;

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


            // Récupérer les données actuelles de l'itinéraire
            $updatedItineraryData = $itinerary;
            $pdfFileName = 'itinerary-summary-' . $itinerary->id . '.pdf';

            // Chemin de destination dans le disque public
            $pdfPath = storage_path('app/public') . '/itineraries/pdf/' . $pdfFileName;

            // Générer le contenu HTML de la vue
            $htmlContent = view('itineraries.summary', ['itinerary' => $updatedItineraryData])->render();

            // Initialiser TCPDF
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Votre Nom');
            $pdf->SetTitle('Résumé Itinéraire');
            $pdf->SetSubject('Exemple TCPDF');
            $pdf->SetKeywords('TCPDF, PDF, itinéraire, résumé, exemple');

            // Ajouter une page
            $pdf->AddPage();

            // Changer la police
            $pdf->SetFont('helvetica', '', 12);

            // Ajouter le contenu HTML à la page
            $pdf->writeHTML($htmlContent, true, false, true, false, '');

            // Convertir le PDF en une chaîne
            $pdfContent = $pdf->Output('', 'S'); // 'S' pour obtenir le contenu sous forme de chaîne

            // Vérifier si le dossier existe et le créer si nécessaire
            $directory = dirname($pdfPath);
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }

            // Écrire le contenu du PDF dans un fichier sur le disque de stockage
            file_put_contents($pdfPath, $pdfContent);

            // Mettre à jour le chemin du PDF dans la base de données
            $itinerary->pdf_url =  basename($pdfPath); // Assurez-vous que le chemin est correctement formé pour une URL
            $itinerary->save();


            if (isset($item['category']) && is_array($item['category'])) {
                foreach ($item['category'] as $categoryName) {
                    $taxonomy = Taxonomy::where('name', $categoryName)->first();
                    if ($taxonomy) {
                        $tagCategorie = TagCategorie::where('taxonomy_id', $taxonomy->id)->first();
                        if ($tagCategorie) {
                            $itinerary->tagCategorie()->attach($tagCategorie->id);
                        }
                    }
                }
            }

            if (isset($item['accessibility']) && is_array($item['accessibility'])) {
                foreach ($item['accessibility'] as $accessibilityName) {
                    $taxonomy = Taxonomy::where('name', $accessibilityName)->first();
                    if ($taxonomy) {
                        $tagAccessibility = TagAccessibility::where('taxonomy_id', $taxonomy->id)->first();
                        if ($tagAccessibility) {
                            $itinerary->tagAccessibility()->attach($tagAccessibility->id);
                        }
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
