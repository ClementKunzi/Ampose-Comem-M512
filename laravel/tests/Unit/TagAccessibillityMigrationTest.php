<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Tests\TestCase;

class TagAccessibilityMigrationTest extends TestCase
{
    /**
     * Test if the tag_accessibility table has been created
     *
     * @return void
     */
    public function testTagAccessibilityTableExists()
    {
        $this->assertTrue(Schema::hasTable('tag_accessibilities'));
    }

    /**
     * Test if the tag_accessibility table has the expected columns
     *
     * @return void
     */
    public function testTagAccessibilityTableHasExpectedColumns()
    {
        $this->assertTrue(
            Schema::hasColumns('tag_accessibilities', [
                'id', 'taxonomy_id', 'created_at', 'updated_at'
            ]),
            1
        );
    }

    /**
     * Test if the tag_accessibility table has foreign keys
     *
     * @return void
     */
    public function testTagAccessibilityTableHasForeignKeys()
    {
        $this->assertTrue(
            Schema::getConnection()->getSchemaBuilder()->hasColumn('tag_accessibilities', 'taxonomy_id')
        );
    }
}
