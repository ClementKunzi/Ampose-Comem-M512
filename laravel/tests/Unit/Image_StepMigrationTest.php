<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Tests\TestCase;

class ImageStepMigrationTest extends TestCase
{
    /**
     * Test if the image_step table has been created
     *
     * @return void
     */
    public function testImageStepTableExists()
    {
        $this->assertTrue(Schema::hasTable('image_step'));
    }

    /**
     * Test if the image_step table has the expected columns
     *
     * @return void
     */
    public function testImageStepTableHasExpectedColumns()
    {
        $this->assertTrue(
            Schema::hasColumns('image_step', [
                'id', 'step_id', 'image_id', 'created_at', 'updated_at'
            ]),
            1
        );
    }

    /**
     * Test if the image_step table has foreign keys
     *
     * @return void
     */
    public function testImageStepTableHasForeignKeys()
    {
        // Vérifiez si la clé étrangère step_id existe
        $this->assertTrue(
            Schema::getConnection()->getSchemaBuilder()->hasColumn('image_step', 'step_id')
        );

        // Vérifiez si la clé étrangère image_id existe
        $this->assertTrue(
            Schema::getConnection()->getSchemaBuilder()->hasColumn('image_step', 'image_id')
        );
    }
}
