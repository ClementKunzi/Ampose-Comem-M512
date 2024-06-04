<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Tests\TestCase;

class BadgeMigrationTest extends TestCase
{
    /**
     * Test if the badges table has been created
     *
     * @return void
     */
    public function testBadgesTableExists()
    {
        $this->assertTrue(Schema::hasTable('badges'));
    }

    /**
     * Test if the badges table has the expected columns
     *
     * @return void
     */
    public function testBadgesTableHasExpectedColumns()
    {
        $this->assertTrue(
            Schema::hasColumns('badges', [
                'id', 'name', 'description', 'badge_picture', 'created_at', 'updated_at'
            ]),
            1
        );
    }
}
