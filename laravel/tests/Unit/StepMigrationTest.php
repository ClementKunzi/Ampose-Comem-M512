<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Tests\TestCase;

class StepMigrationTest extends TestCase
{
    /**
     * Test if the step table has been created
     *
     * @return void
     */
    public function testStepTableExists()
    {
        $this->assertTrue(Schema::hasTable('step'));
    }

    /**
     * Test if the step table has the expected columns
     *
     * @return void
     */
    public function testStepTableHasExpectedColumns()
    {
        $this->assertTrue(
            Schema::hasColumns('step', [
                'id', 'name', 'description', 'adress', 'schedule', 'latitude', 'longitude', 'order', 'external_link', 'itinerary_id', 'created_at', 'updated_at'
            ]),
            1
        );
    }

    /**
     * Test if the step table has foreign keys
     *
     * @return void
     */
    public function testStepTableHasForeignKeys()
    {
        $this->assertTrue(
            Schema::getConnection()->getSchemaBuilder()->hasColumn('step', 'itinerary_id')

        );
    }
}
