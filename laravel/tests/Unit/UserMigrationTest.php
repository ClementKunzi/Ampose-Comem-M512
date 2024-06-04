<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Tests\TestCase;

class UserMigrationTest extends TestCase
{
    /**
     * Test if the users table has been created
     *
     * @return void
     */
    public function testUsersTableExists()
    {
        $this->assertTrue(Schema::hasTable('users'));
    }

    /**
     * Test if the users table has the expected columns
     *
     * @return void
     */
    public function testUsersTableHasExpectedColumns()
    {
        $this->assertTrue(
            Schema::hasColumns('users', [
                'id', 'username', 'last_name', 'first_name', 'email', 'password', 'email_verification',
                'email_verified_at', 'last_login', 'number_path_added', 'profile_picture', 'remember_token', 'created_at', 'updated_at'
            ]),
            1
        );
    }
}
