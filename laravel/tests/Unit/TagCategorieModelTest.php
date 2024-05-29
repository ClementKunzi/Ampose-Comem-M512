<?php

namespace Tests\Unit;

use App\Models\TagCategorie;
use App\Models\Taxonomy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TagCategorieTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_a_taxonomy()
    {
        $taxonomy = Taxonomy::factory()->create();
        $tagCategorie = TagCategorie::factory()->create(['taxonomy_id' => $taxonomy->id]);

        $this->assertEquals($taxonomy->id, $tagCategorie->taxonomy->id);
    }

    /** @test */
    public function it_has_a_taxonomy_id()
    {
        $taxonomy = Taxonomy::factory()->create();
        $tagCategorie = TagCategorie::factory()->create(['taxonomy_id' => $taxonomy->id]);

        $this->assertEquals($taxonomy->id, $tagCategorie->taxonomy_id);
    }

    /** @test */
    public function it_has_a_color()
    {
        $color = 'red';
        $tagCategorie = TagCategorie::factory()->create(['color' => $color]);

        $this->assertEquals($color, $tagCategorie->color);
    }
}
