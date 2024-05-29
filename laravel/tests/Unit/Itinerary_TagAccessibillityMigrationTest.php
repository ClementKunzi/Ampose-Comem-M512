<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Tests\TestCase;

class ItineraryTagAccessibilityMigrationTest extends TestCase
{
    /**
     * Test if the itinerary_tag_accessibility table has been created
     *
     * @return void
     */
    public function testItineraryTagAccessibilityTableExists()
    {
        $this->assertTrue(Schema::hasTable('itinerary_tag_accessibility'));
    }

    /**
     * Test if the itinerary_tag_accessibility table has the expected columns
     *
     * @return void
     */
    public function testItineraryTagAccessibilityTableHasExpectedColumns()
    {
        $this->assertTrue(
            Schema::hasColumns('itinerary_tag_accessibility', [
                'id', 'tag_accessibility_id', 'itinerary_id', 'created_at', 'updated_at'
            ]),
            1
        );
    }

    /**
     * Test if the itinerary_tag_accessibility table has foreign keys
     *
     * @return void
     */
    public function testItineraryTagAccessibilityTableHasForeignKeys()
    {
        $this->assertTrue(
            Schema::hasColumn('itinerary_tag_accessibility', 'tag_accessibility_id')
        );

        $this->assertTrue(
            Schema::hasColumn('itinerary_tag_accessibility', 'itinerary_id')
        );
    }
}
