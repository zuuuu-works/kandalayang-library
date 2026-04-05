<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AccessLog;

class AccessLogSeeder extends Seeder
{
    public function run(): void
    {
        $logs = [
            // Student accessing resources
            ['user_id' => 2, 'e_resource_id' => 1, 'accessed_at' => now()->subDays(10), 'access_type' => 'view'],
            ['user_id' => 2, 'e_resource_id' => 3, 'accessed_at' => now()->subDays(9),  'access_type' => 'download'],
            ['user_id' => 2, 'e_resource_id' => 5, 'accessed_at' => now()->subDays(8),  'access_type' => 'view'],
            ['user_id' => 2, 'e_resource_id' => 8, 'accessed_at' => now()->subDays(5),  'access_type' => 'view'],

            // Faculty accessing resources
            ['user_id' => 3, 'e_resource_id' => 2, 'accessed_at' => now()->subDays(7),  'access_type' => 'view'],
            ['user_id' => 3, 'e_resource_id' => 3, 'accessed_at' => now()->subDays(6),  'access_type' => 'download'],
            ['user_id' => 3, 'e_resource_id' => 6, 'accessed_at' => now()->subDays(4),  'access_type' => 'view'],
            ['user_id' => 3, 'e_resource_id' => 7, 'accessed_at' => now()->subDays(2),  'access_type' => 'stream'],

            // Researcher accessing resources
            ['user_id' => 4, 'e_resource_id' => 2, 'accessed_at' => now()->subDays(12), 'access_type' => 'download'],
            ['user_id' => 4, 'e_resource_id' => 4, 'accessed_at' => now()->subDays(11), 'access_type' => 'view'],
            ['user_id' => 4, 'e_resource_id' => 6, 'accessed_at' => now()->subDays(3),  'access_type' => 'download'],
            ['user_id' => 4, 'e_resource_id' => 8, 'accessed_at' => now()->subDays(1),  'access_type' => 'view'],

            // Librarian also accessing for verification
            ['user_id' => 1, 'e_resource_id' => 1, 'accessed_at' => now()->subDays(15), 'access_type' => 'view'],
            ['user_id' => 1, 'e_resource_id' => 5, 'accessed_at' => now()->subDays(14), 'access_type' => 'download'],

            // Recent accesses (last 2 days — good for report charts)
            ['user_id' => 2, 'e_resource_id' => 2, 'accessed_at' => now()->subHours(5), 'access_type' => 'view'],
            ['user_id' => 3, 'e_resource_id' => 4, 'accessed_at' => now()->subHours(3), 'access_type' => 'view'],
            ['user_id' => 4, 'e_resource_id' => 1, 'accessed_at' => now()->subHours(1), 'access_type' => 'download'],
        ];

        foreach ($logs as $log) {
            AccessLog::create($log);
        }
    }
}