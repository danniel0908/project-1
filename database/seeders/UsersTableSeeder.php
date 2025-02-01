<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            // Superadmin
            [
                'first_name' => 'Super',
                'middle_name' => null,
                'last_name' => 'Admin',
                'suffix' => null,
                'email' => 'superadmin@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'superadmin',
                'phone_number' => 'superadmin',
                'applicant_type' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Admin
            [
                'first_name' => 'System',
                'middle_name' => null,
                'last_name' => 'Administrator',
                'suffix' => null,
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone_number' => 'admin',
                'applicant_type' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // TMU
            [
                'first_name' => 'Transport',
                'middle_name' => null,
                'last_name' => 'Management',
                'suffix' => null,
                'email' => 'tmu@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'tmu',
                'phone_number' => 'tmu',
                'applicant_type' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}