<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EResource;

class EResourceSeeder extends Seeder
{
    public function run(): void
    {
        $resources = [
            [
                'title'            => 'Introduction to Library and Information Science',
                'description'      => 'A comprehensive guide to the fundamentals of library science and information management.',
                'isbn'             => '978-971-000-001-1',
                'publication_year' => 2021,
                'file_url'         => 'https://example.com/resources/lib-info-science.pdf',
                'file_type'        => 'PDF',
                'category_id'      => 1, // E-Books
                'author_id'        => 1, // Juan Dela Cruz
                'publisher_id'     => 5, // Kandalayang Academic Press
            ],
            [
                'title'            => 'Digital Transformation in Philippine Education',
                'description'      => 'Research on the impact of digital tools in Philippine academic institutions.',
                'isbn'             => '978-971-000-002-2',
                'publication_year' => 2022,
                'file_url'         => 'https://example.com/resources/digital-edu.pdf',
                'file_type'        => 'PDF',
                'category_id'      => 2, // Academic Journals
                'author_id'        => 2, // Maria Santos
                'publisher_id'     => 1, // Ateneo Press
            ],
            [
                'title'            => 'E-Learning Systems and Student Performance',
                'description'      => 'A study on how e-learning platforms affect student academic outcomes.',
                'isbn'             => null,
                'publication_year' => 2023,
                'file_url'         => 'https://example.com/resources/elearning-study.pdf',
                'file_type'        => 'PDF',
                'category_id'      => 4, // Research Papers
                'author_id'        => 3, // Jose Reyes
                'publisher_id'     => 2, // UP Press
            ],
            [
                'title'            => 'Climate Change and Biodiversity in Mindanao',
                'description'      => 'Environmental research focusing on biodiversity changes in the Mindanao region.',
                'isbn'             => '978-971-000-004-4',
                'publication_year' => 2022,
                'file_url'         => 'https://example.com/resources/mindanao-biodiversity.pdf',
                'file_type'        => 'PDF',
                'category_id'      => 3, // Theses & Dissertations
                'author_id'        => 4, // Ana Garcia
                'publisher_id'     => 2, // UP Press
            ],
            [
                'title'            => 'Philippine History: Pre-Colonial to Modern Era',
                'description'      => 'A detailed account of Philippine history from ancient times to the present.',
                'isbn'             => '978-971-000-005-5',
                'publication_year' => 2020,
                'file_url'         => 'https://example.com/resources/ph-history.epub',
                'file_type'        => 'ePub',
                'category_id'      => 1, // E-Books
                'author_id'        => 5, // Carlos Mendoza
                'publisher_id'     => 3, // Rex Book Store
            ],
            [
                'title'            => 'Community Health Practices in Rural Philippines',
                'description'      => 'Health research examining medical access and practices in rural Filipino communities.',
                'isbn'             => null,
                'publication_year' => 2023,
                'file_url'         => 'https://example.com/resources/rural-health.pdf',
                'file_type'        => 'PDF',
                'category_id'      => 2, // Academic Journals
                'author_id'        => 6, // Liza Bautista
                'publisher_id'     => 4, // DLSU Press
            ],
            [
                'title'            => 'Database Management Systems: Theory and Practice',
                'description'      => 'Textbook covering relational databases, SQL, and database design principles.',
                'isbn'             => '978-971-000-007-7',
                'publication_year' => 2021,
                'file_url'         => 'https://example.com/resources/dbms-textbook.mp3',
                'file_type'        => 'MP3',
                'category_id'      => 6, // Audio Books
                'author_id'        => 2, // Maria Santos
                'publisher_id'     => 5, // Kandalayang Academic Press
            ],
            [
                'title'            => 'Tech Trends in Southeast Asia',
                'description'      => 'A magazine covering the latest technology developments across Southeast Asian countries.',
                'isbn'             => null,
                'publication_year' => 2024,
                'file_url'         => 'https://example.com/resources/tech-sea-magazine.pdf',
                'file_type'        => 'PDF',
                'category_id'      => 5, // Magazines
                'author_id'        => 1, // Juan Dela Cruz
                'publisher_id'     => 5, // Kandalayang Academic Press
            ],
        ];

        foreach ($resources as $resource) {
            EResource::create($resource);
        }
    }
}
