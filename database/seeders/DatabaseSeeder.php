<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * Order matters — seed parent tables before child tables.
     */
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,   // 1. No dependencies
            AuthorSeeder::class,     // 2. No dependencies
            PublisherSeeder::class,  // 3. No dependencies
            UserSeeder::class,       // 4. No dependencies
            EResourceSeeder::class,  // 5. Needs categories, authors, publishers
            AccessLogSeeder::class,  // 6. Needs users, e_resources
        ]);
    }
}