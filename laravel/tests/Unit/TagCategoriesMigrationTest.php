<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Tests\TestCase;

class TagCategorieMigrationTest extends TestCase
{
    /**
     * Test if the tag_categorie table has been created
     *
     * @return void
     */
    public function testTagCategorieTableExists()
    {
        $this->assertTrue(Schema::hasTable('tag_categories'));
    }

    /**
     * Test if the tag_categorie table has the expected columns
     *
     * @return void
     */
    public function testTagCategorieTableHasExpectedColumns()
    {
        $this->assertTrue(
            Schema::hasColumns('tag_categories', [
                'id', 'color', 'taxonomy_id', 'created_at', 'updated_at'
            ]),
            1
        );
    }

    /**
     * Test if the tag_categorie table has foreign keys
     *
     * @return void
     */
    public function testTagCategorieTableHasForeignKeys()
    {
        $this->assertTrue(
            Schema::getConnection()->getSchemaBuilder()->hasColumn('tag_categories', 'taxonomy_id')
        );
    }
}
