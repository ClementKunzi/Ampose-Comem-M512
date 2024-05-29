<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Tests\TestCase;

class BadgeUserMigrationTest extends TestCase
{
    /**
     * Test if the badge_user table has been created
     *
     * @return void
     */
    public function testBadgeUserTableExists()
    {
        $this->assertTrue(Schema::hasTable('badge_user'));
    }

    /**
     * Test if the badge_user table has the expected columns
     *
     * @return void
     */
    public function testBadgeUserTableHasExpectedColumns()
    {
        $this->assertTrue(
            Schema::hasColumns('badge_user', [
                'id', 'badge_id', 'user_id', 'created_at', 'updated_at'
            ]),
            1
        );
    }

    /**
     * Test if the badge_user table has foreign keys
     *
     * @return void
     */
    public function testBadgeUserTableHasForeignKeys()
    {
        $this->assertTrue(
            Schema::hasColumn('badge_user', 'badge_id')
        );

        $this->assertTrue(
            Schema::hasColumn('badge_user', 'user_id')
        );
    }
}
