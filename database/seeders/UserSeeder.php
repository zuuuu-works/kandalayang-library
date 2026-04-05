<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            // Librarian account (full access)
            [
                'first_name' => 'Admin',
                'last_name'  => 'Librarian',
                'email'      => 'librarian@kandalayang.edu.ph',
                'password'   => Hash::make('password'),
                'role'       => 'librarian',
                'status'     => 'active',
            ],
            // Student account
            [
                'first_name' => 'Juan',
                'last_name'  => 'Student',
                'email'      => 'student@kandalayang.edu.ph',
                'password'   => Hash::make('password'),
                'role'       => 'student',
                'status'     => 'active',
            ],
            // Faculty account
            [
                'first_name' => 'Maria',
                'last_name'  => 'Faculty',
                'email'      => 'faculty@kandalayang.edu.ph',
                'password'   => Hash::make('password'),
                'role'       => 'faculty',
                'status'     => 'active',
            ],
            // Researcher account
            [
                'first_name' => 'Carlos',
                'last_name'  => 'Researcher',
                'email'      => 'researcher@kandalayang.edu.ph',
                'password'   => Hash::make('password'),
                'role'       => 'researcher',
                'status'     => 'active',
            ],
            // Inactive user (to test Business Rule #9)
            [
                'first_name' => 'Inactive',
                'last_name'  => 'User',
                'email'      => 'inactive@kandalayang.edu.ph',
                'password'   => Hash::make('password'),
                'role'       => 'student',
                'status'     => 'inactive',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}