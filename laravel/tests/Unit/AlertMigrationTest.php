<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Tests\TestCase;

class AlertMigrationTest extends TestCase
{
    /**
     * Test if the alerts table has been created
     *
     * @return void
     */
    public function testAlertsTableExists()
    {
        $this->assertTrue(Schema::hasTable('alerts'));
    }

    /**
     * Test if the alerts table has the expected columns
     *
     * @return void
     */
    public function testAlertsTableHasExpectedColumns()
    {
        $this->assertTrue(
            Schema::hasColumns('alerts', [
                'id', 'type', 'description', 'reporting_time', 'itinerary_id', 'user_id', 'created_at', 'updated_at'
            ]),
            1
        );
    }

    /**
     * Test if the alerts table has foreign keys
     *
     * @return void
     */
    public function testAlertsTableHasForeignKeys()
    {
        $this->assertTrue(
            Schema::getConnection()->getSchemaBuilder()->hasColumn('alerts', 'itinerary_id')
        );

        $this->assertTrue(
            Schema::getConnection()->getSchemaBuilder()->hasColumn('alerts', 'user_id')
        );
    }
}
