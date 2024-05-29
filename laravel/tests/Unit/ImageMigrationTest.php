<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Tests\TestCase;

class ImageMigrationTest extends TestCase
{
    /**
     * Test if the images table has been created
     *
     * @return void
     */
    public function testImagesTableExists()
    {
        $this->assertTrue(Schema::hasTable('image'));
    }

    /**
     * Test if the images table has the expected columns
     *
     * @return void
     */
    public function testImagesTableHasExpectedColumns()
    {
        $this->assertTrue(
            Schema::hasColumns('image', [
                'id', 'url', 'alt_attr', 'created_at', 'updated_at'
            ]),
            1
        );
    }
}
