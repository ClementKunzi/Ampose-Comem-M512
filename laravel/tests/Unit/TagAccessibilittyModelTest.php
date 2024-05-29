<?php

namespace Tests\Unit;

use App\Models\TagAccessibility;
use App\Models\Taxonomy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TagAccessibilityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_a_taxonomy()
    {
        $taxonomy = Taxonomy::factory()->create();
        $tagAccessibility = TagAccessibility::factory()->create(['taxonomy_id' => $taxonomy->id]);

        $this->assertEquals($taxonomy->id, $tagAccessibility->taxonomy->id);
    }

    /** @test */
    public function it_has_a_taxonomy_id()
    {
        $taxonomy = Taxonomy::factory()->create();
        $tagAccessibility = TagAccessibility::factory()->create(['taxonomy_id' => $taxonomy->id]);

        $this->assertEquals($taxonomy->id, $tagAccessibility->taxonomy_id);
    }
}
