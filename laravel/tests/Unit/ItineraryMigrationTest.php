<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Tests\TestCase;

class ItineraryMigrationTest extends TestCase
{
    /**
     * Test if the itineraries table has been created
     *
     * @return void
     */
    public function testItinerariesTableExists()
    {
        $this->assertTrue(Schema::hasTable('itineraries'));
    }

    /**
     * Test if the itineraries table has the expected columns
     *
     * @return void
     */
    public function testItinerariesTableHasExpectedColumns()
    {
        $this->assertTrue(
            Schema::hasColumns('itineraries', [
                'id', 'name', 'description', 'type', 'length', 'positive_drop', 'negative_drop',
                'estimated_time', 'difficulty', 'source', 'user_id', 'image_id', 'pdf_url', 'created_at', 'updated_at'
            ]),
            1
        );
    }

    /**
     * Test if the alerts table has foreign keys
     *
     * @return void
     */
    public function testItinerariesTableHasForeignKeys()
    {
        $this->assertTrue(
            Schema::getConnection()->getSchemaBuilder()->hasColumn('itineraries', 'user_id')

        );

        $this->assertTrue(
            Schema::getConnection()->getSchemaBuilder()->hasColumn('itineraries', 'image_id')
        );
    }
}
