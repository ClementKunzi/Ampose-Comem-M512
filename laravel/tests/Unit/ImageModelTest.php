<?php

namespace Tests\Unit;

use App\Models\Image;
use App\Models\Itinerary;
use App\Models\Step;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ImageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the creation of an Image.
     *
     * @return void
     */
    public function test_create_image()
    {
        $image = Image::factory()->create();

        $this->assertDatabaseHas('images', [
            'url' => $image->url,
            'alt_attr' => $image->alt_attr,
        ]);
    }

    /**
     * Test the relationship between Image and Itinerary.
     *
     * @return void
     */
    public function test_image_itinerary_relationship()
    {
        $image = Image::factory()->create();
        $itinerary = Itinerary::factory()->create();

        $image->itineraries()->save($itinerary);

        $this->assertTrue($image->itineraries->contains($itinerary));
    }

    /**
     * Test the relationship between Image and Step.
     *
     * @return void
     */
    public function test_image_step_relationship()
    {
        $image = Image::factory()->create();
        $step = Step::factory()->create();

        $image->steps()->attach($step->id);

        $this->assertTrue($image->steps->contains($step));
    }
}
