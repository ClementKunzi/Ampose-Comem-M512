<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Itinerary;
use App\Models\Step;
use App\Models\Image;
use App\Models\TagCategorie;
use App\Models\TagAccessibility;

class ItineraryControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(); // Seed the database with the necessary data
    }

    public function test_index()
    {
        $response = $this->getJson('/api/itineraries');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => [
                'id', 'name', 'description', 'type', 'estimated_time', 'difficulty', 'source', 'pdf_url',
                'image' => ['url', 'alt_attr'],
                'tagCategorie' => ['name'],
                'tagAccessibility' => ['name'],
            ]
        ]);
    }

    public function test_store()
    {
        Storage::fake('public');
        //$user = User::factory()->create();
        // Manually create a user
        $user = new User;
        $user->username = 'testuser';
        $user->last_name = 'Test';
        $user->first_name = 'User';
        $user->email = 'testuser@example.com';
        $user->password = bcrypt('password');
        // Set other fields as necessary
        $user->save();
        $this->actingAs($user);


        $data = [
            'name' => 'Test Itinerary',
            'description' => 'Test Description',
            'type' => 'hiking',
            'estimated_time' => '3 hours',
            'difficulty' => 'medium',
            'source' => 'Test Source',
            'pdf_url' => 'http://example.com/pdf',
            'image' => UploadedFile::fake()->image('itinerary.jpg'),
            'image_description' => 'Test Image Description',
            'tagCategories' => [TagCategorie::first()->id],
            'tagAccessibilities' => [TagAccessibility::first()->id],
            'steps' => [
                [
                    'name' => 'Step 1',
                    'description' => 'Step 1 Description',
                    'address' => 'Step 1 Address',
                    'latitude' => 12.345678,
                    'longitude' => 98.765432,
                    'order' => 1,
                    'stepImage' => UploadedFile::fake()->image('step1.jpg'),
                    'image_description' => 'Step 1 Image Description',
                ],
            ],
        ];

        $response = $this->actingAs($user)->postJson('/api/itineraries', $data);
        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => ['id', 'name', 'description', 'steps']]);
    }

    public function test_show()
    {
        $user = User::factory()->create();
        $itinerary = Itinerary::factory()->create(['user_id' => $user->id]);

        $response = $this->getJson("/api/itineraries/{$itinerary->id}");
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id', 'name', 'description', 'type', 'estimated_time', 'difficulty', 'source', 'pdf_url',
                'image' => ['url', 'alt_attr'],
                'tagCategorie' => ['name'],
                'tagAccessibility' => ['name'],
            ]
        ]);
    }

    public function test_update()
    {
        $user = User::factory()->create();
        $itinerary = Itinerary::factory()->create(['user_id' => $user->id]);

        $data = [
            'name' => 'Updated Itinerary',
            'description' => 'Updated Description',
        ];

        $response = $this->actingAs($user)->putJson("/api/itineraries/{$itinerary->id}", $data);
        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => 'Updated Itinerary']);
    }

    public function test_destroy()
    {
        $user = User::factory()->create();
        $itinerary = Itinerary::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->deleteJson("/api/itineraries/{$itinerary->id}");
        $response->assertStatus(200);
        $response->assertJson(['message' => 'Itinerary deleted successfully']);
    }
}
