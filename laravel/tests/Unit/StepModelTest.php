<?php

namespace Tests\Unit;

use App\Models\Step;
use App\Models\Itinerary;
use App\Models\Image;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StepTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_an_itinerary()
    {
        $itinerary = Itinerary::factory()->create();
        $step = Step::factory()->create(['itinerary_id' => $itinerary->id]);

        $this->assertEquals($itinerary->id, $step->itinerary->id);
    }

    /** @test */
    public function it_has_many_images()
    {
        $step = Step::factory()->create();
        $image = Image::factory()->create();
        $step->images()->attach($image);

        $this->assertTrue($step->images->contains($image));
    }

    /** @test */
    public function it_has_a_name()
    {
        $step = Step::factory()->create(['name' => 'Test Step']);

        $this->assertEquals('Test Step', $step->name);
    }

    /** @test */
    public function it_has_a_description()
    {
        $step = Step::factory()->create(['description' => 'This is a test step.']);

        $this->assertEquals('This is a test step.', $step->description);
    }

    // Add more tests for other attributes and relationships as needed.
}
