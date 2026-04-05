<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name'        => 'E-Books',
                'description' => 'Digital books available for online reading and download.',
            ],
            [
                'name'        => 'Academic Journals',
                'description' => 'Peer-reviewed scholarly articles and research publications.',
            ],
            [
                'name'        => 'Theses & Dissertations',
                'description' => 'Graduate and postgraduate research papers submitted to universities.',
            ],
            [
                'name'        => 'Research Papers',
                'description' => 'Scientific and academic research documents.',
            ],
            [
                'name'        => 'Magazines',
                'description' => 'Periodical publications covering various topics.',
            ],
            [
                'name'        => 'Audio Books',
                'description' => 'Narrated versions of books in audio format.',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}