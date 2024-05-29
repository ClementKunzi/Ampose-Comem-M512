<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\Itinerary;
use App\Models\User;
use App\Models\Image;
use App\Models\TagCategorie;
use App\Models\TagAccessibility;
use App\Models\Taxonomy;
use Illuminate\Support\Facades\Route;

class ItineraryControllerTest extends TestCase
{
    use RefreshDatabase;


    public function testIndex()
    {
        // Créer des instances de vos modèles
        $user = User::factory()->create();
        $image = Image::factory()->create();
        $tagCategorie = TagCategorie::factory()->create();
        $tagAccessibility = TagAccessibility::factory()->create();
        $taxonomy = Taxonomy::factory()->create();

        // Associer les instances à votre itinéraire
        $itinerary = Itinerary::factory()->create([
            'user_id' => $user->id,
            'image_id' => $image->id,
        ]);

        // Appeler la méthode index
        $response = $this->getJson('/api/itineraries');

        // Vérifier que la réponse a le statut 200
        $response->assertStatus(200);

        // Vérifier que la réponse contient les données attendues
        $response->assertJsonStructure([
            '*' => [
                'id', 'user', 'image'
            ]
        ]);
    }

    public function testStore()
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('itinerary.jpg');

        // Contourner le middleware d'authentification pour le test
        Route::put('/api/itinerary', 'ItineraryController@store');
        //->withoutMiddleware('auth');

        $response = $this->json('PUT', '/api/itinerary', [
            'image' => $file,
            // Ajoutez ici les autres champs requis par votre requête StoreItineraryRequest
        ]);

        $response->assertStatus(200);

        // Vérifiez que le fichier a été stocké...
        $this->assertFileExists(storage_path('app/public/images/' . $file->hashName()));

        // Vérifiez que l'itinéraire a été stocké en base de données...
        $this->assertDatabaseHas('itineraries', [
            'image_id' => 1, // ou utilisez une autre valeur si nécessaire
            // Ajoutez ici les autres champs requis par votre requête StoreItineraryRequest
        ]);
    }
}
