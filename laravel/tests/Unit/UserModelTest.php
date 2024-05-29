<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Badge;
use App\Models\Itinerary;
use App\Models\Alert;
use App\Models\Favorite;
use App\Models\Rating;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_badges()
    {
        $user = User::factory()->has(Badge::factory()->count(3))->create();

        $this->assertCount(3, $user->badges);
    }

    /** @test */
    public function it_has_itineraries()
    {
        $user = User::factory()->has(Itinerary::factory()->count(3))->create();

        $this->assertCount(3, $user->itineraries);
    }

    /** @test */
    public function it_has_alerts()
    {
        $user = User::factory()->has(Alert::factory()->count(3))->create();

        $this->assertCount(3, $user->alerts);
    }

    /** @test */
    public function it_has_favorites()
    {
        $user = User::factory()->has(Favorite::factory()->count(3))->create();

        $this->assertCount(3, $user->favorites);
    }

    /** @test */
    public function it_has_ratings()
    {
        $user = User::factory()->has(Rating::factory()->count(3))->create();

        $this->assertCount(3, $user->ratings);
    }
}
