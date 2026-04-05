<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Author;

class AuthorSeeder extends Seeder
{
    public function run(): void
    {
        $authors = [
            [
                'first_name' => 'Juan',
                'last_name'  => 'Dela Cruz',
                'email'      => 'juan.delacruz@example.com',
                'bio'        => 'Filipino researcher specializing in information science and library management.',
            ],
            [
                'first_name' => 'Maria',
                'last_name'  => 'Santos',
                'email'      => 'maria.santos@example.com',
                'bio'        => 'Professor of Computer Science with expertise in digital libraries.',
            ],
            [
                'first_name' => 'Jose',
                'last_name'  => 'Reyes',
                'email'      => 'jose.reyes@example.com',
                'bio'        => 'Author of multiple academic publications in education technology.',
            ],
            [
                'first_name' => 'Ana',
                'last_name'  => 'Garcia',
                'email'      => 'ana.garcia@example.com',
                'bio'        => 'Award-winning researcher in environmental science.',
            ],
            [
                'first_name' => 'Carlos',
                'last_name'  => 'Mendoza',
                'email'      => 'carlos.mendoza@example.com',
                'bio'        => 'Published author with focus on Philippine history and culture.',
            ],
            [
                'first_name' => 'Liza',
                'last_name'  => 'Bautista',
                'email'      => 'liza.bautista@example.com',
                'bio'        => 'Health sciences researcher and medical journal contributor.',
            ],
        ];

        foreach ($authors as $author) {
            Author::create($author);
        }
    }
}
