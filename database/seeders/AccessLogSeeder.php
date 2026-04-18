<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AccessLog;
use App\Models\User;
use App\Models\EResource;

class AccessLogSeeder extends Seeder
{
    public function run(): void
    {
        // Fetch users by role
        $librarian  = User::where('role', 'librarian')->first();
        $student    = User::where('role', 'student')->first();
        $faculty    = User::where('role', 'faculty')->first();
        $researcher = User::where('role', 'researcher')->first();

        // Fetch resources
        $resources = EResource::all();

        if ($resources->isEmpty()) {
            $this->command->warn('No e-resources found. Run EResourceSeeder first.');
            return;
        }

        $accessTypes = ['view', 'download', 'stream'];

        $logs = [

            // ── Student Access Logs ────────────────────────────
            ['user' => $student, 'resource_title' => 'Pride and Prejudice',                          'days_ago' => 29, 'type' => 'view'],
            ['user' => $student, 'resource_title' => 'Adventures of Huckleberry Finn',               'days_ago' => 27, 'type' => 'view'],
            ['user' => $student, 'resource_title' => 'The Art of War',                               'days_ago' => 25, 'type' => 'download'],
            ['user' => $student, 'resource_title' => 'Pride and Prejudice (Audio)',                  'days_ago' => 22, 'type' => 'stream'],
            ['user' => $student, 'resource_title' => 'Frankenstein; or, The Modern Prometheus',      'days_ago' => 20, 'type' => 'view'],
            ['user' => $student, 'resource_title' => 'The Complete Works of William Shakespeare',    'days_ago' => 18, 'type' => 'view'],
            ['user' => $student, 'resource_title' => 'Introduction to Sociology 3e (OpenStax)',      'days_ago' => 15, 'type' => 'download'],
            ['user' => $student, 'resource_title' => 'Thus Spoke Zarathustra',                       'days_ago' => 12, 'type' => 'view'],
            ['user' => $student, 'resource_title' => 'University Physics Volume 1 (OpenStax)',       'days_ago' => 10, 'type' => 'download'],
            ['user' => $student, 'resource_title' => 'Calculus Volume 1 (OpenStax)',                 'days_ago' => 7,  'type' => 'view'],
            ['user' => $student, 'resource_title' => 'Pride and Prejudice',                          'days_ago' => 5,  'type' => 'download'],
            ['user' => $student, 'resource_title' => 'The Tell-Tale Heart (Audio)',                  'days_ago' => 3,  'type' => 'stream'],
            ['user' => $student, 'resource_title' => 'Adventures of Huckleberry Finn',               'days_ago' => 1,  'type' => 'view'],

            // ── Faculty Access Logs ────────────────────────────
            ['user' => $faculty, 'resource_title' => 'Introduction to Sociology 3e (OpenStax)',      'days_ago' => 28, 'type' => 'download'],
            ['user' => $faculty, 'resource_title' => 'University Physics Volume 1 (OpenStax)',       'days_ago' => 26, 'type' => 'view'],
            ['user' => $faculty, 'resource_title' => 'On the Origin of Species',                     'days_ago' => 24, 'type' => 'download'],
            ['user' => $faculty, 'resource_title' => 'Does the Inertia of a Body Depend Upon Its Energy Content?', 'days_ago' => 22, 'type' => 'view'],
            ['user' => $faculty, 'resource_title' => 'Calculus Volume 1 (OpenStax)',                 'days_ago' => 20, 'type' => 'download'],
            ['user' => $faculty, 'resource_title' => 'The Complete Works of William Shakespeare',    'days_ago' => 17, 'type' => 'view'],
            ['user' => $faculty, 'resource_title' => 'An Introduction to the Linux Kernel',          'days_ago' => 14, 'type' => 'download'],
            ['user' => $faculty, 'resource_title' => 'University Physics Volume 1 (OpenStax)',       'days_ago' => 10, 'type' => 'download'],
            ['user' => $faculty, 'resource_title' => 'Introduction to Sociology 3e (OpenStax)',      'days_ago' => 7,  'type' => 'view'],
            ['user' => $faculty, 'resource_title' => 'Pride and Prejudice',                          'days_ago' => 4,  'type' => 'view'],
            ['user' => $faculty, 'resource_title' => 'Calculus Volume 1 (OpenStax)',                 'days_ago' => 2,  'type' => 'view'],

            // ── Researcher Access Logs ─────────────────────────
            ['user' => $researcher, 'resource_title' => 'Does the Inertia of a Body Depend Upon Its Energy Content?', 'days_ago' => 30, 'type' => 'download'],
            ['user' => $researcher, 'resource_title' => 'Black Holes and Entropy',                   'days_ago' => 28, 'type' => 'view'],
            ['user' => $researcher, 'resource_title' => 'Principia Mathematica — Laws of Motion',    'days_ago' => 26, 'type' => 'download'],
            ['user' => $researcher, 'resource_title' => 'An Introduction to the Linux Kernel',       'days_ago' => 24, 'type' => 'view'],
            ['user' => $researcher, 'resource_title' => 'Sketch of The Analytical Engine by Charles Babbage', 'days_ago' => 21, 'type' => 'download'],
            ['user' => $researcher, 'resource_title' => 'The Interpretation of Dreams',              'days_ago' => 19, 'type' => 'view'],
            ['user' => $researcher, 'resource_title' => 'My Inventions: The Autobiography of Nikola Tesla', 'days_ago' => 16, 'type' => 'download'],
            ['user' => $researcher, 'resource_title' => 'Black Holes and Entropy',                   'days_ago' => 13, 'type' => 'download'],
            ['user' => $researcher, 'resource_title' => 'Does the Inertia of a Body Depend Upon Its Energy Content?', 'days_ago' => 9, 'type' => 'view'],
            ['user' => $researcher, 'resource_title' => 'Principia Mathematica — Laws of Motion',    'days_ago' => 6,  'type' => 'view'],
            ['user' => $researcher, 'resource_title' => 'The Interpretation of Dreams',              'days_ago' => 3,  'type' => 'download'],
            ['user' => $researcher, 'resource_title' => 'An Introduction to the Linux Kernel',       'days_ago' => 1,  'type' => 'download'],

            // ── Librarian Access Logs ──────────────────────────
            ['user' => $librarian, 'resource_title' => 'Pride and Prejudice',                        'days_ago' => 25, 'type' => 'view'],
            ['user' => $librarian, 'resource_title' => 'University Physics Volume 1 (OpenStax)',     'days_ago' => 20, 'type' => 'download'],
            ['user' => $librarian, 'resource_title' => 'Introduction to Sociology 3e (OpenStax)',    'days_ago' => 15, 'type' => 'view'],
            ['user' => $librarian, 'resource_title' => 'The Art of War',                             'days_ago' => 10, 'type' => 'download'],
            ['user' => $librarian, 'resource_title' => 'Black Holes and Entropy',                    'days_ago' => 5,  'type' => 'view'],
            ['user' => $librarian, 'resource_title' => 'Frankenstein; or, The Modern Prometheus',    'days_ago' => 2,  'type' => 'view'],
        ];

        foreach ($logs as $log) {
            if (!$log['user']) continue;

            $resource = EResource::where('title', $log['resource_title'])->first();
            if (!$resource) continue;

            AccessLog::create([
                'user_id'       => $log['user']->id,
                'e_resource_id' => $resource->id,
                'accessed_at'   => now()->subDays($log['days_ago'])->subHours(rand(0, 8)),
                'access_type'   => $log['type'],
            ]);
        }
    }
}