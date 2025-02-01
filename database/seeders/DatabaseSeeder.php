<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create example operator user
        User::factory()->create([
            'first_name' => 'John',
            'middle_name' => 'Doe',
            'last_name' => 'Smith',
            'suffix' => 'Jr',
            'email' => 'operator@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'phone_number' => '9536582180',
            'applicant_type' => 'operator',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // // Create some random users with random applicant types
        // User::factory(5)->create()->each(function ($user) {
        //     $user->update([
        //         'role' => 'user',
        //         'applicant_type' => rand(0, 1) ? 'operator' : 'driver'
        //     ]);
        // });

        // Run the UsersTableSeeder to create admin users
        $this->call(UsersTableSeeder::class);
        $this->call(PredefinedMessageSeeder::class);

    }
}