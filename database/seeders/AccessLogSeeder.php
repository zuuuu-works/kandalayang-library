<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AccessLog;
use App\Models\User;
use App\Models\EResource;

class AccessLogSeeder extends Seeder
{
    // 🔹 Helper: get or create user
    private function getUser($role)
    {
        return User::firstOrCreate(
            ['role' => $role],
            [
                'name' => ucfirst($role),
                'email' => $role . rand(1,100) . '@example.com',
                'password' => bcrypt('password')
            ]
        );
    }

    // 🔹 Helper: get resource safely
    private function getResource($title)
    {
        return EResource::where('title', $title)->first();
    }

    public function run(): void
    {
        // ── Users ─────────────────────────────
        $librarian  = $this->getUser('librarian');
        $student    = $this->getUser('student');
        $faculty    = $this->getUser('faculty');
        $researcher = $this->getUser('researcher');

        // ── Logs ──────────────────────────────
        $logs = [

            ['user' => $student, 'title' => 'Pride and Prejudice', 'days' => 5, 'type' => 'download'],
            ['user' => $student, 'title' => 'The Tell-Tale Heart (Audio)', 'days' => 3, 'type' => 'stream'],

            ['user' => $faculty, 'title' => 'Introduction to Sociology 3e (OpenStax)', 'days' => 7, 'type' => 'view'],
            ['user' => $faculty, 'title' => 'Calculus Volume 1 (OpenStax)', 'days' => 2, 'type' => 'view'],

            ['user' => $researcher, 'title' => 'Black Holes and Entropy', 'days' => 13, 'type' => 'download'],
            ['user' => $researcher, 'title' => 'Does the Inertia of a Body Depend Upon Its Energy Content?', 'days' => 9, 'type' => 'view'],

            ['user' => $librarian, 'title' => 'University Physics Volume 1 (OpenStax)', 'days' => 20, 'type' => 'download'],
            ['user' => $librarian, 'title' => 'Frankenstein; or, The Modern Prometheus', 'days' => 2, 'type' => 'view'],
        ];

        $count = 0;

        foreach ($logs as $log) {

            $resource = $this->getResource($log['title']);

            // ❗ Skip only if resource truly doesn't exist
            if (!$resource) {
                $this->command->warn("Missing resource: {$log['title']}");
                continue;
            }

            AccessLog::create([
                'user_id'       => $log['user']->id,
                'e_resource_id' => $resource->id,
                'accessed_at'   => now()->subDays($log['days'])->subHours(rand(0, 10)),
                'access_type'   => $log['type'],
            ]);

            $count++;
        }

        $this->command->info("✅ {$count} access logs created!");
    }
}