<?php

namespace Tests\Unit;

use App\Models\Taxonomy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaxonomyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_a_name()
    {
        $taxonomy = Taxonomy::factory()->create();

        $this->assertNotEmpty($taxonomy->name);
    }

    /** @test */
    public function it_has_a_description()
    {
        $taxonomy = Taxonomy::factory()->create();

        $this->assertNotEmpty($taxonomy->description);
    }

    /** @test */
    public function it_has_an_icon()
    {
        $taxonomy = Taxonomy::factory()->create();

        $this->assertNotEmpty($taxonomy->icon);
    }
}
