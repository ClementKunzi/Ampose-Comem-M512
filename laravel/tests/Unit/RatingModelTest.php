<?php

namespace Tests\Unit;

use App\Models\Itinerary;
use App\Models\User;
use App\Models\Image;
use App\Models\Step;
use App\Models\Alert;
use App\Models\Favorite;
use App\Models\Rating;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RatingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_a_user()
    {
        $user = User::factory()->create();
        $itinerary = Itinerary::factory()->create(['user_id' => $user->id]);

        $this->assertEquals($user->id, $itinerary->user->id);
    }

    /** @test */
    public function it_belongs_to_an_image()
    {
        $image = Image::factory()->create();
        $itinerary = Itinerary::factory()->create(['image_id' => $image->id]);

        $this->assertEquals($image->id, $itinerary->image->id);
    }

    /** @test */
    public function it_has_many_steps()
    {
        $itinerary = Itinerary::factory()->create();
        $step = Step::factory()->create(['itinerary_id' => $itinerary->id]);

        $this->assertTrue($itinerary->steps->contains($step));
    }

    /** @test */
    public function it_has_many_alerts()
    {
        $itinerary = Itinerary::factory()->create();
        $alert = Alert::factory()->create(['itinerary_id' => $itinerary->id]);

        $this->assertTrue($itinerary->alerts->contains($alert));
    }

    /** @test */
    public function it_has_many_favorites()
    {
        $itinerary = Itinerary::factory()->create();
        $favorite = Favorite::factory()->create(['itinerary_id' => $itinerary->id]);

        $this->assertTrue($itinerary->favorites->contains($favorite));
    }

    /** @test */
    public function it_has_many_ratings()
    {
        $itinerary = Itinerary::factory()->create();
        $rating = Rating::factory()->create(['itinerary_id' => $itinerary->id]);

        $this->assertTrue($itinerary->ratings->contains($rating));
    }
}
