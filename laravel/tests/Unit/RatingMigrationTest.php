<?php

namespace Tests\Unit\Migrations;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Tests\TestCase;

class CreateRatingsTableTest extends TestCase
{
    /**
     * Test if the ratings table was created with the correct columns.
     *
     * @return void
     */
    public function testRatingsTableHasExpectedColumns()
    {
        $this->assertTrue(
            Schema::hasColumns('ratings', [
                'id',
                'note',
                'comment',
                'itinerary_id',
                'user_id',
                'created_at',
                'updated_at'
            ]),
            1
        );
    }
}
