<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Tests\TestCase;

class ItineraryTagCategorieMigrationTest extends TestCase
{
    /**
     * Test if the itinerary_tag_categorie table has been created
     *
     * @return void
     */
    public function testItineraryTagCategorieTableExists()
    {
        $this->assertTrue(Schema::hasTable('itinerary_tag_categorie'));
    }

    /**
     * Test if the itinerary_tag_categorie table has the expected columns
     *
     * @return void
     */
    public function testItineraryTagCategorieTableHasExpectedColumns()
    {
        $this->assertTrue(
            Schema::hasColumns('itinerary_tag_categorie', [
                'id', 'tag_categorie_id', 'itinerary_id', 'created_at', 'updated_at'
            ]),
            1
        );
    }

    /**
     * Test if the itinerary_tag_categorie table has foreign keys
     *
     * @return void
     */
    public function testItineraryTagCategorieTableHasForeignKeys()
    {
        $this->assertTrue(
            Schema::getConnection()->getSchemaBuilder()->hasColumn('itinerary_tag_categorie', 'tag_categorie_id')
        );

        $this->assertTrue(
            Schema::getConnection()->getSchemaBuilder()->hasColumn('itinerary_tag_categorie', 'itinerary_id')
        );
    }
}
