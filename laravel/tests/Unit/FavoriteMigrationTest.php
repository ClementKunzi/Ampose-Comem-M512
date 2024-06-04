<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Tests\TestCase;

class FavoriteMigrationTest extends TestCase
{
    /**
     * Test if the favorite table has been created
     *
     * @return void
     */
    public function testFavoriteTableExists()
    {
        $this->assertTrue(Schema::hasTable('favorites'));
    }

    /**
     * Test if the favorite table has the expected columns
     *
     * @return void
     */
    public function testFavoriteTableHasExpectedColumns()
    {
        $this->assertTrue(
            Schema::hasColumns('favorites', [
                'id', 'itinerary_id', 'user_id', 'created_at', 'updated_at'
            ]),
            1
        );
    }

    /**
     * Test if the favorite table has foreign keys
     *
     * @return void
     */
    public function testFavoriteTableHasForeignKeys()
    {
        $this->assertTrue(
            Schema::hasColumn('favorites', 'itinerary_id')
        );

        $this->assertTrue(
            Schema::hasColumn('favorites', 'user_id')
        );
    }
}
