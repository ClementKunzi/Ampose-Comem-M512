<?php

namespace Tests\Unit;

use App\Models\Badge;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BadgeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the creation of a Badge.
     *
     * @return void
     */
    public function test_create_badge()
    {
        $badge = Badge::factory()->create();

        $this->assertDatabaseHas('badge', [
            'name' => $badge->name,
            'description' => $badge->description,
            'badge_picture' => $badge->badge_picture,
        ]);
    }

    /**
     * Test the relationship between Badge and User.
     *
     * @return void
     */
    public function test_badge_user_relationship()
    {
        $badge = Badge::factory()->create();
        $user = User::factory()->create();

        $user->badges()->attach($badge);

        $this->assertTrue($user->badges->contains($badge));
    }
}
