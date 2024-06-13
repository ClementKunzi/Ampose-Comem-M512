<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Read JSON file
        $json = file_get_contents(database_path() . '/seeders/data/users.json');

        // Decode JSON to array
        $data = json_decode($json, true);

        foreach ($data as $user) {
            // Get image content from URL or local file
            $imageContent = file_get_contents(base_path('database/seeders/data' . $user['profile_picture']));

            $extension = pathinfo($user['profile_picture'], PATHINFO_EXTENSION);

            $newFilename = time() . '_' . uniqid() . '.' . $extension;
            // Define path to save image
            $imagePath = 'public/images/' . $newFilename;


            // Save image to the defined path
            Storage::put($imagePath, $newFilename);

            $newFilename = 'images/' . $newFilename;

            // Insert data into the users table
            DB::table('users')->insert([
                'username' => $user['username'],
                'last_name' => $user['lastname'],
                'first_name' => $user['firstname'],
                'email' => $user['email'],
                'password' => Hash::make($user['password']),
                'profile_picture' => $newFilename,
            ]);
        }
    }
}
