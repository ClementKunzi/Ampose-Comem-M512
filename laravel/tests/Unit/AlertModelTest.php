<?php

namespace Tests\Unit;

use App\Models\Alert;
use App\Models\User;
use App\Models\Itinerary;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class AlertTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function it_can_create_an_alert()
    {
        $user = User::factory()->create();
        $itinerary = Itinerary::factory()->create();

        $alert = Alert::create([
            'type' => $this->faker->word,
            'description' => $this->faker->sentence,
            'reporting_time' => now(),
            'itinerary_id' => $itinerary->id,
            'user_id' => $user->id,
        ]);

        $this->assertDatabaseHas('alerts', [
            'id' => $alert->id,
            'type' => $alert->type,
            'description' => $alert->description,
            'itinerary_id' => $itinerary->id,
            'user_id' => $user->id,
        ]);
    }

    /** @test */
    public function it_has_a_user_relation()
    {
        $user = User::factory()->create();
        $alert = Alert::factory()->create(['user_id' => $user->id]);

        $this->assertEquals($user->id, $alert->user->id);
    }

    /** @test */
    public function it_has_an_itinerary_relation()
    {
        $itinerary = Itinerary::factory()->create();
        $alert = Alert::factory()->create(['itinerary_id' => $itinerary->id]);

        $this->assertEquals($itinerary->id, $alert->itinerary->id);
    }
}
