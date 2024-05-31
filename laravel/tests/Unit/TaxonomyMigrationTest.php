<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Tests\TestCase;

class TaxonomyMigrationTest extends TestCase
{
    /**
     * Test if the taxonomy table has been created
     *
     * @return void
     */
    public function testTaxonomyTableExists()
    {
        $this->assertTrue(Schema::hasTable('taxonomies'));
    }

    /**
     * Test if the taxonomy table has the expected columns
     *
     * @return void
     */
    public function testTaxonomyTableHasExpectedColumns()
    {
        $this->assertTrue(
            Schema::hasColumns('taxonomies', [
                'id', 'name', 'icon', 'description', 'created_at', 'updated_at'
            ]),
            1
        );
    }
}
